<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'supplier_id',
        'sku',
        'name',
        'description',
        'unit',
        'min_stock',
        'max_stock',
        'purchase_price',
        'selling_price',
        'image',
        'is_active',
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function productStocks()
    {
        return $this->hasMany(ProductStock::class);
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    public function purchaseOrderItems()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function salesOrderItems()
    {
        return $this->hasMany(SalesOrderItem::class);
    }

    public function stockAdjustments()
    {
        return $this->hasMany(StockAdjustment::class);
    }

    // Methods
    public function getTotalStock()
    {
        return $this->productStocks()->sum('quantity');
    }

    public function getStockByWarehouse($warehouseId)
    {
        $stock = $this->productStocks()
            ->where('warehouse_id', $warehouseId)
            ->first();

        return $stock ? $stock->quantity : 0;
    }

    public function getAvailableStockByWarehouse($warehouseId)
    {
        $stock = $this->productStocks()
            ->where('warehouse_id', $warehouseId)
            ->first();

        if (!$stock) {
            return 0;
        }

        return max(0, $stock->quantity - $stock->reserved_quantity);
    }

    public function isLowStock()
    {
        return $this->getTotalStock() <= $this->min_stock;
    }

    public function isOutOfStock()
    {
        return $this->getTotalStock() <= 0;
    }

    // Accessors
    public function getFormattedPurchasePriceAttribute()
    {
        return 'Rp ' . number_format((float) $this->purchase_price, 0, ',', '.');
    }

    public function getFormattedSellingPriceAttribute()
    {
        return 'Rp ' . number_format((float) $this->selling_price, 0, ',', '.');
    }

    public function getProfitMarginAttribute()
    {
        if ($this->purchase_price == 0) {
            return 0;
        }

        return (($this->selling_price - $this->purchase_price) / $this->purchase_price) * 100;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeLowStock($query)
    {
        return $query->whereRaw('(SELECT COALESCE(SUM(quantity), 0) FROM product_stocks WHERE product_stocks.product_id = products.id) <= products.min_stock');
    }

    public function scopeOutOfStock($query)
    {
        return $query->whereRaw('(SELECT COALESCE(SUM(quantity), 0) FROM product_stocks WHERE product_stocks.product_id = products.id) <= 0');
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
                ->orWhere('sku', 'like', "%{$term}%")
                ->orWhere('description', 'like', "%{$term}%");
        });
    }
}
