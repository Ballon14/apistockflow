<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'warehouse_id',
        'quantity',
        'reserved_quantity',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'reserved_quantity' => 'integer',
    ];

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    // Methods
    public function addStock($quantity)
    {
        $this->increment('quantity', $quantity);
        return $this;
    }

    public function reduceStock($quantity)
    {
        if ($this->getAvailableQuantity() < $quantity) {
            throw new \Exception('Insufficient stock available');
        }

        $this->decrement('quantity', $quantity);
        return $this;
    }

    public function reserve($quantity)
    {
        if ($this->getAvailableQuantity() < $quantity) {
            throw new \Exception('Insufficient stock to reserve');
        }

        $this->increment('reserved_quantity', $quantity);
        return $this;
    }

    public function release($quantity)
    {
        $this->decrement('reserved_quantity', min($quantity, $this->reserved_quantity));
        return $this;
    }

    public function getAvailableQuantity()
    {
        return max(0, $this->quantity - $this->reserved_quantity);
    }

    // Accessors
    public function getAvailableQuantityAttribute()
    {
        return $this->getAvailableQuantity();
    }
}
