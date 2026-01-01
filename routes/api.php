<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\WarehouseController;
use App\Http\Controllers\Api\PurchaseOrderController;
use App\Http\Controllers\Api\SalesOrderController;
use App\Http\Controllers\Api\StockMovementController;
use App\Http\Controllers\Api\StockAdjustmentController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);

    // Dashboard
    Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
    Route::get('/dashboard/recent-movements', [DashboardController::class, 'recentMovements']);
    Route::get('/dashboard/low-stock-products', [DashboardController::class, 'lowStockProducts']);

    // Categories
    Route::apiResource('categories', CategoryController::class);
    Route::get('/categories/{category}/products', [CategoryController::class, 'products']);

    // Suppliers
    Route::apiResource('suppliers', SupplierController::class);

    // Products
    Route::apiResource('products', ProductController::class);
    Route::get('/products-low-stock', [ProductController::class, 'lowStock']);
    Route::get('/products/{product}/stock-history', [ProductController::class, 'stockHistory']);
    Route::post('/products/{product}/upload-image', [ProductController::class, 'uploadImage']);
    Route::get('/products/{product}/qr-code', [ProductController::class, 'generateQRCode']);
    Route::post('/products/scan-qr', [ProductController::class, 'scanQRCode']);

    // Warehouses
    Route::apiResource('warehouses', WarehouseController::class);
    Route::get('/warehouses/{warehouse}/stocks', [WarehouseController::class, 'stocks']);

    // Stock Movements
    Route::get('/stock-movements', [StockMovementController::class, 'index']);
    Route::get('/stock-movements/{stockMovement}', [StockMovementController::class, 'show']);
    Route::post('/stock-movements/transfer', [StockMovementController::class, 'transfer']);

    // Purchase Orders
    Route::apiResource('purchase-orders', PurchaseOrderController::class);
    Route::post('/purchase-orders/{purchaseOrder}/approve', [PurchaseOrderController::class, 'approve']);
    Route::post('/purchase-orders/{purchaseOrder}/complete', [PurchaseOrderController::class, 'complete']);
    Route::post('/purchase-orders/{purchaseOrder}/cancel', [PurchaseOrderController::class, 'cancel']);

    // Sales Orders
    Route::apiResource('sales-orders', SalesOrderController::class);
    Route::post('/sales-orders/{salesOrder}/confirm', [SalesOrderController::class, 'confirm']);
    Route::post('/sales-orders/{salesOrder}/ship', [SalesOrderController::class, 'ship']);
    Route::post('/sales-orders/{salesOrder}/deliver', [SalesOrderController::class, 'deliver']);
    Route::post('/sales-orders/{salesOrder}/cancel', [SalesOrderController::class, 'cancel']);


    // Stock Adjustments
    Route::apiResource('stock-adjustments', StockAdjustmentController::class)->only(['index', 'store', 'show']);

    // User Management (Admin Only)
    Route::middleware('admin')->group(function () {
        Route::apiResource('users', UserController::class);
        Route::post('/users/{user}/reset-password', [UserController::class, 'resetPassword']);
        Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus']);
        Route::get('/users/{user}/activity', [UserController::class, 'activity']);
    });
});
