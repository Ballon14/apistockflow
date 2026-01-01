<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_order_id',
        'product_id',
        'quantity',
        'unit_price',
        'subtotal',
        'received_quantity',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'received_quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($item) {
            $item->subtotal = $item->calculateSubtotal();
        });

        static::saved(function ($item) {
            $item->purchaseOrder->calculateTotal();
        });

        static::deleted(function ($item) {
            $item->purchaseOrder->calculateTotal();
        });
    }

    // Relationships
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Methods
    public function calculateSubtotal()
    {
        return $this->quantity * $this->unit_price;
    }

    public function receive($quantity)
    {
        if ($quantity > ($this->quantity - $this->received_quantity)) {
            throw new \Exception('Received quantity cannot exceed ordered quantity');
        }

        $this->received_quantity += $quantity;
        $this->save();

        return $this;
    }
}
