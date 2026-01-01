<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\PurchaseOrder;
use App\Models\SalesOrder;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function stats(Request $request)
    {
        $totalProducts = Product::active()->count();
        $totalWarehouses = Warehouse::active()->count();
        $lowStockProducts = Product::whereRaw('(SELECT SUM(quantity) FROM product_stocks WHERE product_id = products.id) <= products.min_stock')->count();
        $outOfStockProducts = Product::whereRaw('(SELECT SUM(quantity) FROM product_stocks WHERE product_id = products.id) <= 0')->count();
        
        $totalStockValue = DB::table('product_stocks')
            ->join('products', 'products.id', '=', 'product_stocks.product_id')
            ->selectRaw('SUM(product_stocks.quantity * products.purchase_price) as total_value')
            ->value('total_value') ?? 0;

        $pendingPO = PurchaseOrder::where('status', 'pending')->count();
        $completedPO = PurchaseOrder::where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->count();

        $confirmedSO = SalesOrder::where('status', 'confirmed')->count();
        $deliveredSO = SalesOrder::where('status', 'delivered')
            ->whereMonth('created_at', now()->month)
            ->count();

        return response()->json([
            'success' => true,
            'data' => [
                'products' => [
                    'total' => $totalProducts,
                    'low_stock' => $lowStockProducts,
                    'out_of_stock' => $outOfStockProducts,
                ],
                'warehouses' => [
                    'total' => $totalWarehouses,
                    'total_stock_value' => $totalStockValue,
                ],
                'purchase_orders' => [
                    'pending' => $pendingPO,
                    'completed_this_month' => $completedPO,
                ],
                'sales_orders' => [
                    'confirmed' => $confirmedSO,
                    'delivered_this_month' => $deliveredSO,
                ],
            ],
        ]);
    }

    public function recentMovements(Request $request)
    {
        $movements = StockMovement::with(['product', 'warehouse', 'user'])
            ->latest()
            ->take(20)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $movements,
        ]);
    }

    public function lowStockProducts(Request $request)
    {
        $products = Product::with(['category', 'supplier', 'productStocks.warehouse'])
            ->whereRaw('(SELECT SUM(quantity) FROM product_stocks WHERE product_id = products.id) <= products.min_stock')
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'sku' => $product->sku,
                    'name' => $product->name,
                    'category' => $product->category->name,
                    'min_stock' => $product->min_stock,
                    'current_stock' => $product->getTotalStock(),
                    'stock_by_warehouse' => $product->productStocks->map(function ($stock) {
                        return [
                            'warehouse' => $stock->warehouse->name,
                            'quantity' => $stock->quantity,
                        ];
                    }),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }
}
