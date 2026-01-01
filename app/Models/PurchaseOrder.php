<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class PurchaseOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'po_number',
        'supplier_id',
        'warehouse_id',
        'order_date',
        'expected_delivery_date',
        'status',
        'total_amount',
        'notes',
        'created_by',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'order_date' => 'date',
        'expected_delivery_date' => 'date',
        'approved_at' => 'datetime',
        'total_amount' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($po) {
            if (empty($po->po_number)) {
                $po->po_number = $po->generatePONumber();
            }
        });
    }

    // Relationships
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function stockMovements()
    {
        return $this->morphMany(StockMovement::class, 'reference');
    }

    // Methods
    public function generatePONumber()
    {
        $date = now()->format('Ymd');
        $lastPO = static::whereDate('created_at', today())
            ->orderBy('id', 'desc')
            ->first();

        $sequence = $lastPO ? (int) substr($lastPO->po_number, -4) + 1 : 1;

        return 'PO-' . $date . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    public function calculateTotal()
    {
        $this->total_amount = $this->items()->sum('subtotal');
        $this->save();

        return $this->total_amount;
    }

    public function approve($userId)
    {
        if ($this->status !== 'pending') {
            throw new \Exception('Only pending purchase orders can be approved');
        }

        $this->status = 'approved';
        $this->approved_by = $userId;
        $this->approved_at = now();
        $this->save();

        return $this;
    }

    public function complete($userId)
    {
        if ($this->status !== 'approved') {
            throw new \Exception('Only approved purchase orders can be completed');
        }

        DB::transaction(function () use ($userId) {
            foreach ($this->items as $item) {
                // Update or create product stock
                $stock = ProductStock::firstOrCreate(
                    [
                        'product_id' => $item->product_id,
                        'warehouse_id' => $this->warehouse_id,
                    ],
                    ['quantity' => 0, 'reserved_quantity' => 0]
                );

                $stock->addStock($item->quantity);

                // Create stock movement
                StockMovement::create([
                    'product_id' => $item->product_id,
                    'warehouse_id' => $this->warehouse_id,
                    'type' => 'IN',
                    'quantity' => $item->quantity,
                    'reference_type' => PurchaseOrder::class,
                    'reference_id' => $this->id,
                    'notes' => "Purchase Order: {$this->po_number}",
                    'created_by' => $userId,
                ]);

                // Update received quantity
                $item->received_quantity = $item->quantity;
                $item->save();
            }

            $this->status = 'completed';
            $this->save();
        });

        return $this;
    }

    public function cancel()
    {
        if (!in_array($this->status, ['draft', 'pending', 'approved'])) {
            throw new \Exception('Only draft, pending, or approved purchase orders can be cancelled');
        }

        $this->status = 'cancelled';
        $this->save();

        return $this;
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('order_date', [$startDate, $endDate]);
    }
}
