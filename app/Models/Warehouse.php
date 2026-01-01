<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'address',
        'city',
        'country',
        'manager_name',
        'phone',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function productStocks()
    {
        return $this->hasMany(ProductStock::class);
    }

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }

    public function salesOrders()
    {
        return $this->hasMany(SalesOrder::class);
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    public function stockAdjustments()
    {
        return $this->hasMany(StockAdjustment::class);
    }

    // Methods
    public function getTotalProducts()
    {
        return $this->productStocks()->where('quantity', '>', 0)->count();
    }

    public function getTotalStockValue()
    {
        return $this->productStocks()
            ->join('products', 'products.id', '=', 'product_stocks.product_id')
            ->selectRaw('SUM(product_stocks.quantity * products.purchase_price) as total_value')
            ->value('total_value') ?? 0;
    }

    public function getAvailableStock($productId)
    {
        $stock = $this->productStocks()
            ->where('product_id', $productId)
            ->first();

        if (!$stock) {
            return 0;
        }

        return max(0, $stock->quantity - $stock->reserved_quantity);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
