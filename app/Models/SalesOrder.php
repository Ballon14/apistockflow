<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class SalesOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'so_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'warehouse_id',
        'order_date',
        'delivery_date',
        'status',
        'total_amount',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'order_date' => 'date',
        'delivery_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($so) {
            if (empty($so->so_number)) {
                $so->so_number = $so->generateSONUmber();
            }
        });
    }

    // Relationships
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function items()
    {
        return $this->hasMany(SalesOrderItem::class);
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
    public function generateSONUmber()
    {
        $date = now()->format('Ymd');
        $lastSO = static::whereDate('created_at', today())
            ->orderBy('id', 'desc')
            ->first();

        $sequence = $lastSO ? (int) substr($lastSO->so_number, -4) + 1 : 1;

        return 'SO-' . $date . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    public function calculateTotal()
    {
        $this->total_amount = $this->items()->sum('subtotal');
        $this->save();

        return $this->total_amount;
    }

    public function validateStock()
    {
        foreach ($this->items as $item) {
            $availableStock = $item->product->getAvailableStockByWarehouse($this->warehouse_id);
            
            if ($availableStock < $item->quantity) {
                throw new \Exception("Insufficient stock for product: {$item->product->name}. Available: {$availableStock}, Requested: {$item->quantity}");
            }
        }

        return true;
    }

    public function confirm($userId)
    {
        if ($this->status !== 'draft') {
            throw new \Exception('Only draft sales orders can be confirmed');
        }

        DB::transaction(function () use ($userId) {
            // Validate stock availability
            $this->validateStock();

            // Reserve stock for each item
            foreach ($this->items as $item) {
                $stock = ProductStock::where('product_id', $item->product_id)
                    ->where('warehouse_id', $this->warehouse_id)
                    ->firstOrFail();

                $stock->reserve($item->quantity);
            }

            $this->status = 'confirmed';
            $this->save();
        });

        return $this;
    }

    public function ship($userId)
    {
        if ($this->status !== 'confirmed' && $this->status !== 'processing') {
            throw new \Exception('Only confirmed or processing sales orders can be shipped');
        }

        DB::transaction(function () use ($userId) {
            foreach ($this->items as $item) {
                $stock = ProductStock::where('product_id', $item->product_id)
                    ->where('warehouse_id', $this->warehouse_id)
                    ->firstOrFail();

                // Release reserved and reduce actual stock
                $stock->release($item->quantity);
                $stock->reduceStock($item->quantity);

                // Create stock movement
                StockMovement::create([
                    'product_id' => $item->product_id,
                    'warehouse_id' => $this->warehouse_id,
                    'type' => 'OUT',
                    'quantity' => -$item->quantity, // negative for OUT
                    'reference_type' => SalesOrder::class,
                    'reference_id' => $this->id,
                    'notes' => "Sales Order: {$this->so_number}",
                    'created_by' => $userId,
                ]);
            }

            $this->status = 'shipped';
            $this->save();
        });

        return $this;
    }

    public function deliver()
    {
        if ($this->status !== 'shipped') {
            throw new \Exception('Only shipped sales orders can be marked as delivered');
        }

        $this->status = 'delivered';
        $this->save();

        return $this;
    }

    public function cancel($userId)
    {
        if (!in_array($this->status, ['draft', 'confirmed', 'processing'])) {
            throw new \Exception('Only draft, confirmed, or processing sales orders can be cancelled');
        }

        DB::transaction(function () use ($userId) {
            // Release reserved stock if order was confirmed
            if ($this->status === 'confirmed' || $this->status === 'processing') {
                foreach ($this->items as $item) {
                    $stock = ProductStock::where('product_id', $item->product_id)
                        ->where('warehouse_id', $this->warehouse_id)
                        ->first();

                    if ($stock) {
                        $stock->release($item->quantity);
                    }
                }
            }

            $this->status = 'cancelled';
            $this->save();
        });

        return $this;
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('order_date', [$startDate, $endDate]);
    }
}
