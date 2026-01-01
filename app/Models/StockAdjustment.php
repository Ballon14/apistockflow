<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class StockAdjustment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'adjustment_number',
        'product_id',
        'warehouse_id',
        'type',
        'quantity',
        'reason',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($adjustment) {
            if (empty($adjustment->adjustment_number)) {
                $adjustment->adjustment_number = $adjustment->generateAdjustmentNumber();
            }

            // Auto-apply adjustment on creation
            $adjustment->apply();
        });
    }

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function stockMovements()
    {
        return $this->morphMany(StockMovement::class, 'reference');
    }

    // Methods
    public function generateAdjustmentNumber()
    {
        $date = now()->format('Ymd');
        $lastAdjustment = static::whereDate('created_at', today())
            ->orderBy('id', 'desc')
            ->first();

        $sequence = $lastAdjustment ? (int) substr($lastAdjustment->adjustment_number, -4) + 1 : 1;

        return 'ADJ-' . $date . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    public function apply()
    {
        DB::transaction(function () {
            // Update or create product stock
            $stock = ProductStock::firstOrCreate(
                [
                    'product_id' => $this->product_id,
                    'warehouse_id' => $this->warehouse_id,
                ],
                ['quantity' => 0, 'reserved_quantity' => 0]
            );

            // Adjust stock
            if ($this->type === 'increase') {
                $stock->addStock($this->quantity);
                $movementType = 'ADJUSTMENT';
                $movementQuantity = $this->quantity;
            } else {
                $stock->reduceStock($this->quantity);
                $movementType = 'ADJUSTMENT';
                $movementQuantity = -$this->quantity;
            }

            // Create stock movement
            StockMovement::create([
                'product_id' => $this->product_id,
                'warehouse_id' => $this->warehouse_id,
                'type' => $movementType,
                'quantity' => $movementQuantity,
                'reference_type' => StockAdjustment::class,
                'reference_id' => $this->id,
                'notes' => "Stock Adjustment: {$this->reason}",
                'created_by' => $this->created_by,
            ]);
        });

        return $this;
    }
}
