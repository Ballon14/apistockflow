# Application Routes

This document contains a comprehensive list of all registered routes in the application, including the new Filament admin panel routes, API endpoints, and system routes.

### Resources

#### Products
| Method | URI | Name |
| :--- | :--- | :--- |
| GET | `admin/products` | `filament.admin.resources.products.index` |
| GET | `admin/products/create` | `filament.admin.resources.products.create` |
| GET | `admin/products/{record}/edit` | `filament.admin.resources.products.edit` |

#### Categories
| Method | URI | Name |
| :--- | :--- | :--- |
| GET | `admin/categories` | `filament.admin.resources.categories.index` |
| GET | `admin/categories/create` | `filament.admin.resources.categories.create` |
| GET | `admin/categories/{record}/edit` | `filament.admin.resources.categories.edit` |

#### Suppliers
| Method | URI | Name |
| :--- | :--- | :--- |
| GET | `admin/suppliers` | `filament.admin.resources.suppliers.index` |
| GET | `admin/suppliers/create` | `filament.admin.resources.suppliers.create` |
| GET | `admin/suppliers/{record}/edit` | `filament.admin.resources.suppliers.edit` |

#### Warehouses
| Method | URI | Name |
| :--- | :--- | :--- |
| GET | `admin/warehouses` | `filament.admin.resources.warehouses.index` |
| GET | `admin/warehouses/create` | `filament.admin.resources.warehouses.create` |
| GET | `admin/warehouses/{record}/edit` | `filament.admin.resources.warehouses.edit` |

#### Purchase Orders
| Method | URI | Name |
| :--- | :--- | :--- |
| GET | `admin/purchase-orders` | `filament.admin.resources.purchase-orders.index` |
| GET | `admin/purchase-orders/create` | `filament.admin.resources.purchase-orders.create` |
| GET | `admin/purchase-orders/{record}/edit` | `filament.admin.resources.purchase-orders.edit` |

#### Sales Orders
| Method | URI | Name |
| :--- | :--- | :--- |
| GET | `admin/sales-orders` | `filament.admin.resources.sales-orders.index` |
| GET | `admin/sales-orders/create` | `filament.admin.resources.sales-orders.create` |
| GET | `admin/sales-orders/{record}/edit` | `filament.admin.resources.sales-orders.edit` |

#### Stock Adjustments
| Method | URI | Name |
| :--- | :--- | :--- |
| GET | `admin/stock-adjustments` | `filament.admin.resources.stock-adjustments.index` |
| GET | `admin/stock-adjustments/create` | `filament.admin.resources.stock-adjustments.create` |
| GET | `admin/stock-adjustments/{record}/edit` | `filament.admin.resources.stock-adjustments.edit` |

#### Stock Movements
| Method | URI | Name |
| :--- | :--- | :--- |
| GET | `admin/stock-movements` | `filament.admin.resources.stock-movements.index` |
| GET | `admin/stock-movements/create` | `filament.admin.resources.stock-movements.create` |
| GET | `admin/stock-movements/{record}/edit` | `filament.admin.resources.stock-movements.edit` |

#### Users
| Method | URI | Name |
| :--- | :--- | :--- |
| GET | `admin/users` | `filament.admin.resources.users.index` |
| GET | `admin/users/create` | `filament.admin.resources.users.create` |
| GET | `admin/users/{record}/edit` | `filament.admin.resources.users.edit` |

## API Routes

### Authentication
| Method | URI | Name |
| :--- | :--- | :--- |
| POST | `api/login` | `Api\AuthController@login` |
| POST | `api/register` | `Api\AuthController@register` |
| POST | `api/logout` | `Api\AuthController@logout` |
| GET | `api/me` | `Api\AuthController@me` |
| PUT | `api/profile` | `Api\AuthController@updateProfile` |

### Dashboard
| Method | URI | Name |
| :--- | :--- | :--- |
| GET | `api/dashboard/stats` | `Api\DashboardController@stats` |
| GET | `api/dashboard/recent-movements` | `Api\DashboardController@recentMovements` |
| GET | `api/dashboard/low-stock-products` | `Api\DashboardController@lowStockProducts` |

### Products
| Method | URI | Name |
| :--- | :--- | :--- |
| GET | `api/products` | `products.index` |
| POST | `api/products` | `products.store` |
| GET | `api/products/{product}` | `products.show` |
| PUT/PATCH | `api/products/{product}` | `products.update` |
| DELETE | `api/products/{product}` | `products.destroy` |
| GET | `api/products-low-stock` | `Api\ProductController@lowStock` |
| GET | `api/products/{product}/stock-history` | `Api\ProductController@stockHistory` |
| GET | `api/products/{product}/qr-code` | `Api\ProductController@getQrCode` |
| POST | `api/products/{product}/upload-image` | `Api\ProductController@uploadImage` |
| POST | `api/products/scan-qr` | `Api\ProductController@scanQrCode` |

### Categories
| Method | URI | Name |
| :--- | :--- | :--- |
| GET | `api/categories` | `categories.index` |
| POST | `api/categories` | `categories.store` |
| GET | `api/categories/{category}` | `categories.show` |
| PUT/PATCH | `api/categories/{category}` | `categories.update` |
| DELETE | `api/categories/{category}` | `categories.destroy` |
| GET | `api/categories/{category}/products` | `Api\CategoryController@products` |

### Suppliers
| Method | URI | Name |
| :--- | :--- | :--- |
| GET | `api/suppliers` | `suppliers.index` |
| POST | `api/suppliers` | `suppliers.store` |
| GET | `api/suppliers/{supplier}` | `suppliers.show` |
| PUT/PATCH | `api/suppliers/{supplier}` | `suppliers.update` |
| DELETE | `api/suppliers/{supplier}` | `suppliers.destroy` |

### Warehouses
| Method | URI | Name |
| :--- | :--- | :--- |
| GET | `api/warehouses` | `warehouses.index` |
| POST | `api/warehouses` | `warehouses.store` |
| GET | `api/warehouses/{warehouse}` | `warehouses.show` |
| PUT/PATCH | `api/warehouses/{warehouse}` | `warehouses.update` |
| DELETE | `api/warehouses/{warehouse}` | `warehouses.destroy` |
| GET | `api/warehouses/{warehouse}/stocks` | `Api\WarehouseController@stocks` |

### Purchase Orders
| Method | URI | Name |
| :--- | :--- | :--- |
| GET | `api/purchase-orders` | `purchase-orders.index` |
| POST | `api/purchase-orders` | `purchase-orders.store` |
| GET | `api/purchase-orders/{purchase_order}` | `purchase-orders.show` |
| PUT/PATCH | `api/purchase-orders/{purchase_order}` | `purchase-orders.update` |
| DELETE | `api/purchase-orders/{purchase_order}` | `purchase-orders.destroy` |
| POST | `api/purchase-orders/{purchaseOrder}/approve` | `Api\PurchaseOrderController@approve` |
| POST | `api/purchase-orders/{purchaseOrder}/complete` | `Api\PurchaseOrderController@complete` |
| POST | `api/purchase-orders/{purchaseOrder}/cancel` | `Api\PurchaseOrderController@cancel` |

### Sales Orders
| Method | URI | Name |
| :--- | :--- | :--- |
| GET | `api/sales-orders` | `sales-orders.index` |
| POST | `api/sales-orders` | `sales-orders.store` |
| GET | `api/sales-orders/{sales_order}` | `sales-orders.show` |
| PUT/PATCH | `api/sales-orders/{sales_order}` | `sales-orders.update` |
| DELETE | `api/sales-orders/{sales_order}` | `sales-orders.destroy` |
| POST | `api/sales-orders/{salesOrder}/confirm` | `Api\SalesOrderController@confirm` |
| POST | `api/sales-orders/{salesOrder}/ship` | `Api\SalesOrderController@ship` |
| POST | `api/sales-orders/{salesOrder}/deliver` | `Api\SalesOrderController@deliver` |
| POST | `api/sales-orders/{salesOrder}/cancel` | `Api\SalesOrderController@cancel` |

### Stock Management
| Method | URI | Name |
| :--- | :--- | :--- |
| GET | `api/stock-adjustments` | `stock-adjustments.index` |
| POST | `api/stock-adjustments` | `stock-adjustments.store` |
| GET | `api/stock-adjustments/{stock_adjustment}` | `stock-adjustments.show` |
| GET | `api/stock-movements` | `Api\StockMovementController@index` |
| GET | `api/stock-movements/{stockMovement}` | `Api\StockMovementController@show` |
| POST | `api/stock-movements/transfer` | `Api\StockMovementController@transfer` |

### Users
| Method | URI | Name |
| :--- | :--- | :--- |
| GET | `api/users` | `users.index` |
| POST | `api/users` | `users.store` |
| GET | `api/users/{user}` | `users.show` |
| PUT/PATCH | `api/users/{user}` | `users.update` |
| DELETE | `api/users/{user}` | `users.destroy` |
| POST | `api/users/{user}/reset-password` | `Api\UserController@resetPassword` |
| POST | `api/users/{user}/toggle-status` | `Api\UserController@toggleStatus` |
| GET | `api/users/{user}/activity` | `Api\UserController@activity` |

## System & Assets Rules
| Method | URI | Name |
| :--- | :--- | :--- |
| GET | `livewire/livewire.js` | `Livewire Assets` |
| POST | `livewire/update` | `Livewire Update` |
| POST | `livewire/upload-file` | `Livewire File Upload` |
| GET | `sanctum/csrf-cookie` | `sanctum.csrf-cookie` |
| GET | `storage/{path}` | `Storage Assets` |
| GET | `up` | `Health Check` |
