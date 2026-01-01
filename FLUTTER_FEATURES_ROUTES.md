# StockFlow - Flutter Frontend Features & Routes

Dokumentasi lengkap fitur-fitur yang direkomendasikan untuk aplikasi Flutter StockFlow, termasuk data yang dibutuhkan dan routing untuk setiap halaman.

---

## 📱 Struktur Navigasi Aplikasi

```
StockFlow App
├── Authentication
│   ├── Login
│   ├── Register
│   └── Profile
├── Dashboard
├── Inventory Management
│   ├── Products
│   ├── Categories
│   └── Suppliers
├── Warehouse Management
│   ├── Warehouses
│   └── Stock Transfer
├── Order Management
│   ├── Purchase Orders
│   └── Sales Orders
├── Stock Operations
│   ├── Stock Movements
│   └── Stock Adjustments
└── Settings
    └── User Management
```

---

## 🔐 1. Authentication Module

### 1.1 Login Screen

**Route:** `/login`

**Fitur:**
- Form login dengan email dan password
- Remember me checkbox
- Forgot password link
- Validasi input real-time
- Loading state saat login
- Error handling dengan snackbar

**Data yang Dibutuhkan:**
```dart
class LoginRequest {
  final String email;
  final String password;
}

class LoginResponse {
  final bool success;
  final String message;
  final UserData user;
  final String accessToken;
  final String tokenType;
}

class UserData {
  final int id;
  final String name;
  final String email;
  final String role;
  final String? phone;
  final String? avatar;
}
```

**API Endpoint:**
- `POST /api/login`

---

### 1.2 Register Screen

**Route:** `/register`

**Fitur:**
- Form registrasi lengkap
- Password strength indicator
- Password confirmation
- Role selection (untuk admin)
- Terms & conditions checkbox
- Validasi email format

**Data yang Dibutuhkan:**
```dart
class RegisterRequest {
  final String name;
  final String email;
  final String password;
  final String passwordConfirmation;
  final String? phone;
  final String role; // default: 'staff'
}

class RegisterResponse {
  final bool success;
  final String message;
  final UserData user;
  final String accessToken;
  final String tokenType;
}
```

**API Endpoint:**
- `POST /api/register`

---

### 1.3 Profile Screen

**Route:** `/profile`

**Fitur:**
- Tampilkan informasi user
- Edit profile (name, phone, avatar)
- Change password
- Logout button
- Activity log user

**Data yang Dibutuhkan:**
```dart
class ProfileUpdateRequest {
  final String name;
  final String? phone;
  final File? avatar;
}

class UserProfile {
  final int id;
  final String name;
  final String email;
  final String role;
  final String? phone;
  final String? avatar;
  final DateTime createdAt;
  final DateTime? lastLoginAt;
}
```

**API Endpoint:**
- `GET /api/me`
- `PUT /api/profile`
- `POST /api/logout`

---

## 📊 2. Dashboard Module

### 2.1 Dashboard Screen

**Route:** `/dashboard` atau `/`

**Fitur:**
- Summary cards (Total Products, Warehouses, Orders, Stock Value)
- Chart pergerakan stok (7 hari terakhir)
- Low stock alerts dengan badge
- Recent stock movements list
- Quick actions (Add Product, Create PO, Create SO)
- Filter by date range

**Data yang Dibutuhkan:**
```dart
class DashboardStats {
  final ProductStats products;
  final WarehouseStats warehouses;
  final PurchaseOrderStats purchaseOrders;
  final SalesOrderStats salesOrders;
}

class ProductStats {
  final int total;
  final int lowStock;
  final int outOfStock;
}

class WarehouseStats {
  final int total;
  final double totalStockValue;
}

class PurchaseOrderStats {
  final int pending;
  final int completedThisMonth;
}

class SalesOrderStats {
  final int confirmed;
  final int deliveredThisMonth;
}

class RecentMovement {
  final int id;
  final String type; // IN, OUT, TRANSFER, ADJUSTMENT
  final String productName;
  final String warehouseName;
  final int quantity;
  final DateTime createdAt;
}

class LowStockProduct {
  final int id;
  final String sku;
  final String name;
  final int currentStock;
  final int minStock;
  final String warehouseName;
}
```

**API Endpoint:**
- `GET /api/dashboard/stats`
- `GET /api/dashboard/recent-movements`
- `GET /api/dashboard/low-stock-products`

---

## 📦 3. Inventory Management Module

### 3.1 Product List Screen

**Route:** `/products`

**Fitur:**
- List produk dengan pagination
- Search by name/SKU
- Filter by category, supplier, status
- Sort by name, stock, price
- Pull to refresh
- Card view dengan image, name, SKU, stock
- Floating action button untuk add product
- Swipe actions (edit, delete)

**Data yang Dibutuhkan:**
```dart
class ProductList {
  final List<Product> data;
  final PaginationMeta meta;
}

class Product {
  final int id;
  final int categoryId;
  final int supplierId;
  final String sku;
  final String name;
  final String? description;
  final String unit;
  final int minStock;
  final int maxStock;
  final double purchasePrice;
  final double sellingPrice;
  final bool isActive;
  final String? imagePath;
  final String? imageUrl;
  final Category category;
  final Supplier supplier;
  final int totalStock;
  final DateTime createdAt;
}

class PaginationMeta {
  final int currentPage;
  final int lastPage;
  final int perPage;
  final int total;
}
```

**API Endpoint:**
- `GET /api/products?page=1&search=laptop&category_id=1`

---

### 3.2 Product Detail Screen

**Route:** `/products/:id`

**Fitur:**
- Tampilkan detail lengkap produk
- Image gallery (jika ada multiple images)
- QR Code display & download
- Stock by warehouse (list)
- Stock movement history
- Edit & Delete buttons (role-based)
- Share product info

**Data yang Dibutuhkan:**
```dart
class ProductDetail {
  final Product product;
  final List<StockByWarehouse> stockByWarehouse;
  final List<StockMovement> recentMovements;
}

class StockByWarehouse {
  final int warehouseId;
  final String warehouseName;
  final int quantity;
  final int availableQuantity;
  final int reservedQuantity;
}

class StockMovement {
  final int id;
  final String type;
  final int quantity;
  final String warehouseName;
  final String? reference;
  final DateTime createdAt;
}
```

**API Endpoint:**
- `GET /api/products/{id}`
- `GET /api/products/{id}/stock-history`
- `GET /api/products/{id}/qr-code`

---

### 3.3 Add/Edit Product Screen

**Route:** `/products/add` dan `/products/:id/edit`

**Fitur:**
- Form input lengkap
- Image picker & preview
- Category dropdown (searchable)
- Supplier dropdown (searchable)
- Auto-generate SKU option
- Price calculator (margin %)
- Min/Max stock validation
- Save as draft option

**Data yang Dibutuhkan:**
```dart
class ProductFormData {
  final int? id;
  final int categoryId;
  final int supplierId;
  final String sku;
  final String name;
  final String? description;
  final String unit;
  final int minStock;
  final int maxStock;
  final double purchasePrice;
  final double sellingPrice;
  final bool isActive;
  final File? image;
}
```

**API Endpoint:**
- `POST /api/products`
- `PUT /api/products/{id}`
- `POST /api/products/{id}/upload-image`

---

### 3.4 QR Scanner Screen

**Route:** `/products/scan`

**Fitur:**
- Camera view untuk scan QR
- Flash toggle
- Gallery picker (scan from image)
- Auto-detect QR code
- Vibration feedback
- Navigate to product detail setelah scan

**Data yang Dibutuhkan:**
```dart
class QRScanRequest {
  final String qrData;
}

class QRScanResponse {
  final Product product;
  final int totalStock;
  final List<StockByWarehouse> stockByWarehouse;
}
```

**API Endpoint:**
- `POST /api/products/scan-qr`

---

### 3.5 Category List Screen

**Route:** `/categories`

**Fitur:**
- List kategori dengan nested support
- Tree view untuk parent-child
- Product count per category
- Add/Edit/Delete category
- Drag to reorder

**Data yang Dibutuhkan:**
```dart
class Category {
  final int id;
  final int? parentId;
  final String name;
  final String? description;
  final int productCount;
  final List<Category>? children;
  final DateTime createdAt;
}
```

**API Endpoint:**
- `GET /api/categories`
- `POST /api/categories`
- `PUT /api/categories/{id}`
- `DELETE /api/categories/{id}`
- `GET /api/categories/{id}/products`

---

### 3.6 Supplier List Screen

**Route:** `/suppliers`

**Fitur:**
- List supplier dengan card view
- Search by name/contact
- Contact actions (call, email, WhatsApp)
- Add/Edit/Delete supplier
- View products from supplier

**Data yang Dibutuhkan:**
```dart
class Supplier {
  final int id;
  final String name;
  final String? contactPerson;
  final String? email;
  final String? phone;
  final String? address;
  final String? city;
  final String? country;
  final bool isActive;
  final int productCount;
  final DateTime createdAt;
}
```

**API Endpoint:**
- `GET /api/suppliers`
- `POST /api/suppliers`
- `PUT /api/suppliers/{id}`
- `DELETE /api/suppliers/{id}`

---

## 🏢 4. Warehouse Management Module

### 4.1 Warehouse List Screen

**Route:** `/warehouses`

**Fitur:**
- List warehouse dengan card view
- Show total stock value per warehouse
- Location map integration
- Add/Edit/Delete warehouse
- View stocks in warehouse

**Data yang Dibutuhkan:**
```dart
class Warehouse {
  final int id;
  final String name;
  final String code;
  final String address;
  final String city;
  final String country;
  final String? managerName;
  final String? phone;
  final bool isActive;
  final double? latitude;
  final double? longitude;
  final int productCount;
  final double totalStockValue;
  final DateTime createdAt;
}
```

**API Endpoint:**
- `GET /api/warehouses`
- `POST /api/warehouses`
- `PUT /api/warehouses/{id}`
- `DELETE /api/warehouses/{id}`

---

### 4.2 Warehouse Detail Screen

**Route:** `/warehouses/:id`

**Fitur:**
- Detail warehouse info
- Map view lokasi
- List produk di warehouse
- Stock value summary
- Recent movements
- Quick transfer button

**Data yang Dibutuhkan:**
```dart
class WarehouseDetail {
  final Warehouse warehouse;
  final List<WarehouseStock> stocks;
  final List<StockMovement> recentMovements;
}

class WarehouseStock {
  final int productId;
  final String productName;
  final String sku;
  final int quantity;
  final int availableQuantity;
  final int reservedQuantity;
  final double stockValue;
}
```

**API Endpoint:**
- `GET /api/warehouses/{id}`
- `GET /api/warehouses/{id}/stocks`

---

### 4.3 Stock Transfer Screen

**Route:** `/stock-transfer`

**Fitur:**
- Select product (dengan autocomplete)
- Select from warehouse
- Select to warehouse
- Input quantity dengan validasi
- Show available stock
- Notes field
- Confirmation dialog

**Data yang Dibutuhkan:**
```dart
class StockTransferRequest {
  final int productId;
  final int fromWarehouseId;
  final int toWarehouseId;
  final int quantity;
  final String? notes;
}

class StockTransferResponse {
  final bool success;
  final String message;
  final StockMovement movement;
}
```

**API Endpoint:**
- `POST /api/stock-movements/transfer`

---

## 📥 5. Purchase Order Module

### 5.1 Purchase Order List Screen

**Route:** `/purchase-orders`

**Fitur:**
- List PO dengan status badge
- Filter by status (draft, pending, approved, completed)
- Filter by supplier
- Filter by date range
- Search by PO number
- Status color coding
- Swipe actions based on status

**Data yang Dibutuhkan:**
```dart
class PurchaseOrder {
  final int id;
  final String orderNumber;
  final int supplierId;
  final int warehouseId;
  final String status; // draft, pending, approved, completed, cancelled
  final DateTime orderDate;
  final DateTime? expectedDeliveryDate;
  final DateTime? receivedDate;
  final double totalAmount;
  final String? notes;
  final Supplier supplier;
  final Warehouse warehouse;
  final int itemCount;
  final DateTime createdAt;
}
```

**API Endpoint:**
- `GET /api/purchase-orders?status=pending&supplier_id=1`

---

### 5.2 Purchase Order Detail Screen

**Route:** `/purchase-orders/:id`

**Fitur:**
- Header info (PO number, supplier, warehouse, dates)
- Status timeline (draft → pending → approved → completed)
- List items dengan subtotal
- Total amount calculation
- Action buttons based on status:
  - Draft: Edit, Submit
  - Pending: Approve, Reject
  - Approved: Complete, Cancel
- Print/Export PDF

**Data yang Dibutuhkan:**
```dart
class PurchaseOrderDetail {
  final PurchaseOrder order;
  final List<PurchaseOrderItem> items;
  final List<StatusHistory> statusHistory;
}

class PurchaseOrderItem {
  final int id;
  final int productId;
  final String productName;
  final String sku;
  final int quantity;
  final double unitPrice;
  final double subtotal;
  final Product product;
}

class StatusHistory {
  final String status;
  final String? notes;
  final String userName;
  final DateTime createdAt;
}
```

**API Endpoint:**
- `GET /api/purchase-orders/{id}`
- `POST /api/purchase-orders/{id}/approve`
- `POST /api/purchase-orders/{id}/complete`
- `POST /api/purchase-orders/{id}/cancel`

---

### 5.3 Create/Edit Purchase Order Screen

**Route:** `/purchase-orders/add` dan `/purchase-orders/:id/edit`

**Fitur:**
- Select supplier (searchable dropdown)
- Select warehouse
- Date pickers (order date, expected delivery)
- Add items section:
  - Product autocomplete
  - Quantity input
  - Unit price input
  - Remove item button
- Running total calculation
- Notes field
- Save as draft / Submit

**Data yang Dibutuhkan:**
```dart
class PurchaseOrderFormData {
  final int? id;
  final int supplierId;
  final int warehouseId;
  final DateTime orderDate;
  final DateTime expectedDeliveryDate;
  final String? notes;
  final List<PurchaseOrderItemForm> items;
}

class PurchaseOrderItemForm {
  final int productId;
  final int quantity;
  final double unitPrice;
}
```

**API Endpoint:**
- `POST /api/purchase-orders`
- `PUT /api/purchase-orders/{id}`

---

## 📤 6. Sales Order Module

### 6.1 Sales Order List Screen

**Route:** `/sales-orders`

**Fitur:**
- List SO dengan status badge
- Filter by status (draft, confirmed, shipped, delivered)
- Filter by customer
- Filter by date range
- Search by SO number
- Revenue summary
- Swipe actions based on status

**Data yang Dibutuhkan:**
```dart
class SalesOrder {
  final int id;
  final String orderNumber;
  final String customerName;
  final String? customerEmail;
  final String? customerPhone;
  final int warehouseId;
  final String status; // draft, confirmed, shipped, delivered, cancelled
  final DateTime orderDate;
  final DateTime? deliveryDate;
  final double totalAmount;
  final String? notes;
  final Warehouse warehouse;
  final int itemCount;
  final DateTime createdAt;
}
```

**API Endpoint:**
- `GET /api/sales-orders?status=confirmed`

---

### 6.2 Sales Order Detail Screen

**Route:** `/sales-orders/:id`

**Fitur:**
- Header info (SO number, customer, warehouse, dates)
- Status timeline (draft → confirmed → shipped → delivered)
- Customer contact buttons (call, email, WhatsApp)
- List items dengan subtotal
- Total amount calculation
- Action buttons based on status:
  - Draft: Edit, Confirm
  - Confirmed: Ship, Cancel
  - Shipped: Deliver
- Print/Export invoice

**Data yang Dibutuhkan:**
```dart
class SalesOrderDetail {
  final SalesOrder order;
  final List<SalesOrderItem> items;
  final List<StatusHistory> statusHistory;
}

class SalesOrderItem {
  final int id;
  final int productId;
  final String productName;
  final String sku;
  final int quantity;
  final double unitPrice;
  final double subtotal;
  final Product product;
}
```

**API Endpoint:**
- `GET /api/sales-orders/{id}`
- `POST /api/sales-orders/{id}/confirm`
- `POST /api/sales-orders/{id}/ship`
- `POST /api/sales-orders/{id}/deliver`
- `POST /api/sales-orders/{id}/cancel`

---

### 6.3 Create/Edit Sales Order Screen

**Route:** `/sales-orders/add` dan `/sales-orders/:id/edit`

**Fitur:**
- Customer info form (name, email, phone)
- Select warehouse
- Date pickers (order date, delivery date)
- Add items section:
  - Product autocomplete (show available stock)
  - Quantity input dengan validasi stock
  - Unit price input
  - Remove item button
- Running total calculation
- Notes field
- Save as draft / Confirm order

**Data yang Dibutuhkan:**
```dart
class SalesOrderFormData {
  final int? id;
  final String customerName;
  final String? customerEmail;
  final String? customerPhone;
  final int warehouseId;
  final DateTime orderDate;
  final DateTime deliveryDate;
  final String? notes;
  final List<SalesOrderItemForm> items;
}

class SalesOrderItemForm {
  final int productId;
  final int quantity;
  final double unitPrice;
}
```

**API Endpoint:**
- `POST /api/sales-orders`
- `PUT /api/sales-orders/{id}`

---

## 📊 7. Stock Operations Module

### 7.1 Stock Movement List Screen

**Route:** `/stock-movements`

**Fitur:**
- List semua pergerakan stok
- Filter by type (IN, OUT, TRANSFER, ADJUSTMENT)
- Filter by product
- Filter by warehouse
- Filter by date range
- Color coding by type
- Export to Excel/PDF

**Data yang Dibutuhkan:**
```dart
class StockMovement {
  final int id;
  final int productId;
  final int warehouseId;
  final String type; // IN, OUT, TRANSFER, ADJUSTMENT
  final int quantity;
  final int balanceBefore;
  final int balanceAfter;
  final String? reference;
  final String? notes;
  final Product product;
  final Warehouse warehouse;
  final DateTime createdAt;
}
```

**API Endpoint:**
- `GET /api/stock-movements?type=IN&product_id=1&warehouse_id=1`

---

### 7.2 Stock Movement Detail Screen

**Route:** `/stock-movements/:id`

**Fitur:**
- Detail lengkap movement
- Product info
- Warehouse info
- Reference link (ke PO/SO jika ada)
- Balance before/after
- User who created
- Timestamp

**Data yang Dibutuhkan:**
```dart
class StockMovementDetail {
  final StockMovement movement;
  final User? createdBy;
  final dynamic? referenceData; // PO atau SO detail
}
```

**API Endpoint:**
- `GET /api/stock-movements/{id}`

---

### 7.3 Stock Adjustment Screen

**Route:** `/stock-adjustments`

**Fitur:**
- List stock adjustments
- Create new adjustment
- Select product
- Select warehouse
- Select type (increase/decrease)
- Input quantity
- Reason dropdown (stock opname, damaged, expired, etc)
- Notes field
- Confirmation dialog

**Data yang Dibutuhkan:**
```dart
class StockAdjustment {
  final int id;
  final int productId;
  final int warehouseId;
  final String type; // increase, decrease
  final int quantity;
  final String reason;
  final String? notes;
  final Product product;
  final Warehouse warehouse;
  final User createdBy;
  final DateTime createdAt;
}

class StockAdjustmentFormData {
  final int productId;
  final int warehouseId;
  final String type;
  final int quantity;
  final String reason;
  final String? notes;
}
```

**API Endpoint:**
- `GET /api/stock-adjustments`
- `POST /api/stock-adjustments`
- `GET /api/stock-adjustments/{id}`

---

## ⚙️ 8. Settings Module

### 8.1 User Management Screen

**Route:** `/users` (Admin only)

**Fitur:**
- List users dengan role badge
- Filter by role
- Search by name/email
- Add/Edit/Delete user
- Reset password
- Toggle user status (active/inactive)
- View user activity log

**Data yang Dibutuhkan:**
```dart
class User {
  final int id;
  final String name;
  final String email;
  final String role; // admin, manager, staff
  final String? phone;
  final String? avatar;
  final bool isActive;
  final DateTime? lastLoginAt;
  final DateTime createdAt;
}

class UserFormData {
  final int? id;
  final String name;
  final String email;
  final String? password;
  final String? passwordConfirmation;
  final String role;
  final String? phone;
  final bool isActive;
}

class UserActivity {
  final int id;
  final String action;
  final String? description;
  final DateTime createdAt;
}
```

**API Endpoint:**
- `GET /api/users`
- `POST /api/users`
- `PUT /api/users/{id}`
- `DELETE /api/users/{id}`
- `POST /api/users/{id}/reset-password`
- `POST /api/users/{id}/toggle-status`
- `GET /api/users/{id}/activity`

---

## 🗺️ Route Configuration (Flutter)

### Recommended Package: `go_router`

```dart
final router = GoRouter(
  initialLocation: '/login',
  routes: [
    // Authentication
    GoRoute(
      path: '/login',
      name: 'login',
      builder: (context, state) => const LoginScreen(),
    ),
    GoRoute(
      path: '/register',
      name: 'register',
      builder: (context, state) => const RegisterScreen(),
    ),
    
    // Main App (requires auth)
    ShellRoute(
      builder: (context, state, child) => MainLayout(child: child),
      routes: [
        // Dashboard
        GoRoute(
          path: '/',
          name: 'dashboard',
          builder: (context, state) => const DashboardScreen(),
        ),
        
        // Profile
        GoRoute(
          path: '/profile',
          name: 'profile',
          builder: (context, state) => const ProfileScreen(),
        ),
        
        // Products
        GoRoute(
          path: '/products',
          name: 'products',
          builder: (context, state) => const ProductListScreen(),
          routes: [
            GoRoute(
              path: 'add',
              name: 'product-add',
              builder: (context, state) => const ProductFormScreen(),
            ),
            GoRoute(
              path: ':id',
              name: 'product-detail',
              builder: (context, state) {
                final id = int.parse(state.pathParameters['id']!);
                return ProductDetailScreen(productId: id);
              },
              routes: [
                GoRoute(
                  path: 'edit',
                  name: 'product-edit',
                  builder: (context, state) {
                    final id = int.parse(state.pathParameters['id']!);
                    return ProductFormScreen(productId: id);
                  },
                ),
              ],
            ),
            GoRoute(
              path: 'scan',
              name: 'product-scan',
              builder: (context, state) => const QRScannerScreen(),
            ),
          ],
        ),
        
        // Categories
        GoRoute(
          path: '/categories',
          name: 'categories',
          builder: (context, state) => const CategoryListScreen(),
        ),
        
        // Suppliers
        GoRoute(
          path: '/suppliers',
          name: 'suppliers',
          builder: (context, state) => const SupplierListScreen(),
        ),
        
        // Warehouses
        GoRoute(
          path: '/warehouses',
          name: 'warehouses',
          builder: (context, state) => const WarehouseListScreen(),
          routes: [
            GoRoute(
              path: ':id',
              name: 'warehouse-detail',
              builder: (context, state) {
                final id = int.parse(state.pathParameters['id']!);
                return WarehouseDetailScreen(warehouseId: id);
              },
            ),
          ],
        ),
        
        // Stock Transfer
        GoRoute(
          path: '/stock-transfer',
          name: 'stock-transfer',
          builder: (context, state) => const StockTransferScreen(),
        ),
        
        // Purchase Orders
        GoRoute(
          path: '/purchase-orders',
          name: 'purchase-orders',
          builder: (context, state) => const PurchaseOrderListScreen(),
          routes: [
            GoRoute(
              path: 'add',
              name: 'purchase-order-add',
              builder: (context, state) => const PurchaseOrderFormScreen(),
            ),
            GoRoute(
              path: ':id',
              name: 'purchase-order-detail',
              builder: (context, state) {
                final id = int.parse(state.pathParameters['id']!);
                return PurchaseOrderDetailScreen(orderId: id);
              },
              routes: [
                GoRoute(
                  path: 'edit',
                  name: 'purchase-order-edit',
                  builder: (context, state) {
                    final id = int.parse(state.pathParameters['id']!);
                    return PurchaseOrderFormScreen(orderId: id);
                  },
                ),
              ],
            ),
          ],
        ),
        
        // Sales Orders
        GoRoute(
          path: '/sales-orders',
          name: 'sales-orders',
          builder: (context, state) => const SalesOrderListScreen(),
          routes: [
            GoRoute(
              path: 'add',
              name: 'sales-order-add',
              builder: (context, state) => const SalesOrderFormScreen(),
            ),
            GoRoute(
              path: ':id',
              name: 'sales-order-detail',
              builder: (context, state) {
                final id = int.parse(state.pathParameters['id']!);
                return SalesOrderDetailScreen(orderId: id);
              },
              routes: [
                GoRoute(
                  path: 'edit',
                  name: 'sales-order-edit',
                  builder: (context, state) {
                    final id = int.parse(state.pathParameters['id']!);
                    return SalesOrderFormScreen(orderId: id);
                  },
                ),
              ],
            ),
          ],
        ),
        
        // Stock Movements
        GoRoute(
          path: '/stock-movements',
          name: 'stock-movements',
          builder: (context, state) => const StockMovementListScreen(),
          routes: [
            GoRoute(
              path: ':id',
              name: 'stock-movement-detail',
              builder: (context, state) {
                final id = int.parse(state.pathParameters['id']!);
                return StockMovementDetailScreen(movementId: id);
              },
            ),
          ],
        ),
        
        // Stock Adjustments
        GoRoute(
          path: '/stock-adjustments',
          name: 'stock-adjustments',
          builder: (context, state) => const StockAdjustmentScreen(),
        ),
        
        // Users (Admin only)
        GoRoute(
          path: '/users',
          name: 'users',
          builder: (context, state) => const UserManagementScreen(),
        ),
      ],
    ),
  ],
  
  // Redirect logic
  redirect: (context, state) {
    final isLoggedIn = AuthService.instance.isAuthenticated;
    final isLoginRoute = state.matchedLocation == '/login';
    
    if (!isLoggedIn && !isLoginRoute) {
      return '/login';
    }
    if (isLoggedIn && isLoginRoute) {
      return '/';
    }
    return null;
  },
);
```

---

## 📦 Recommended Flutter Packages

```yaml
dependencies:
  # State Management
  flutter_riverpod: ^2.4.0
  
  # Routing
  go_router: ^13.0.0
  
  # HTTP Client
  dio: ^5.4.0
  
  # Local Storage
  shared_preferences: ^2.2.2
  flutter_secure_storage: ^9.0.0
  
  # UI Components
  flutter_svg: ^2.0.9
  cached_network_image: ^3.3.1
  shimmer: ^3.0.0
  
  # Forms & Validation
  flutter_form_builder: ^9.1.1
  form_builder_validators: ^9.1.0
  
  # QR Code
  qr_flutter: ^4.1.0
  mobile_scanner: ^3.5.5
  
  # Charts
  fl_chart: ^0.66.0
  
  # Date/Time
  intl: ^0.19.0
  
  # Image Picker
  image_picker: ^1.0.7
  
  # PDF Generation
  pdf: ^3.10.7
  printing: ^5.12.0
  
  # Maps (optional)
  google_maps_flutter: ^2.5.3
  
  # Utilities
  logger: ^2.0.2+1
  connectivity_plus: ^5.0.2
```

---

## 🎨 UI/UX Recommendations

### Color Scheme
```dart
class AppColors {
  // Primary
  static const primary = Color(0xFF2196F3);
  static const primaryDark = Color(0xFF1976D2);
  static const primaryLight = Color(0xFFBBDEFB);
  
  // Status Colors
  static const success = Color(0xFF4CAF50);
  static const warning = Color(0xFFFF9800);
  static const error = Color(0xFFF44336);
  static const info = Color(0xFF2196F3);
  
  // Stock Status
  static const stockIn = Color(0xFF4CAF50);
  static const stockOut = Color(0xFFF44336);
  static const stockTransfer = Color(0xFF2196F3);
  static const stockAdjustment = Color(0xFFFF9800);
  
  // Order Status
  static const draft = Color(0xFF9E9E9E);
  static const pending = Color(0xFFFF9800);
  static const approved = Color(0xFF2196F3);
  static const completed = Color(0xFF4CAF50);
  static const cancelled = Color(0xFFF44336);
}
```

### Typography
```dart
class AppTextStyles {
  static const heading1 = TextStyle(
    fontSize: 24,
    fontWeight: FontWeight.bold,
  );
  
  static const heading2 = TextStyle(
    fontSize: 20,
    fontWeight: FontWeight.bold,
  );
  
  static const body1 = TextStyle(
    fontSize: 16,
    fontWeight: FontWeight.normal,
  );
  
  static const caption = TextStyle(
    fontSize: 12,
    color: Colors.grey,
  );
}
```

---

## 🔒 Security Best Practices

1. **Token Management**
   - Store token di `flutter_secure_storage`
   - Auto-refresh token sebelum expired
   - Clear token on logout

2. **API Communication**
   - Gunakan HTTPS
   - Implement request timeout
   - Handle network errors gracefully

3. **Input Validation**
   - Client-side validation
   - Sanitize user input
   - Prevent SQL injection

4. **Role-Based Access**
   - Check user role sebelum navigate
   - Hide/disable actions based on role
   - Validate permissions on backend

---

## 📱 Offline Support (Optional)

### Recommended Packages
```yaml
dependencies:
  sqflite: ^2.3.2
  hive: ^2.2.3
  connectivity_plus: ^5.0.2
```

### Features to Cache
- Dashboard stats (last sync)
- Product list (read-only)
- Categories & Suppliers
- User profile

### Sync Strategy
- Queue write operations when offline
- Sync when connection restored
- Show sync status indicator
- Handle conflicts

---

## 🧪 Testing Recommendations

```yaml
dev_dependencies:
  flutter_test:
    sdk: flutter
  mockito: ^5.4.4
  integration_test:
    sdk: flutter
```

### Test Coverage
- Unit tests untuk models & services
- Widget tests untuk UI components
- Integration tests untuk critical flows
- API mocking untuk testing

---

## 📈 Performance Optimization

1. **Lazy Loading**
   - Pagination untuk list
   - Infinite scroll
   - Image lazy loading

2. **Caching**
   - Cache network images
   - Cache API responses
   - Use `const` widgets

3. **Code Splitting**
   - Lazy load routes
   - Separate large features

4. **Build Optimization**
   - Use `const` constructors
   - Avoid unnecessary rebuilds
   - Profile with DevTools

---

## 🚀 Deployment Checklist

- [ ] Configure environment variables
- [ ] Setup API base URL (dev/staging/prod)
- [ ] Configure app icons & splash screen
- [ ] Setup Firebase (optional - analytics, crashlytics)
- [ ] Configure ProGuard rules (Android)
- [ ] Setup code signing (iOS)
- [ ] Test on multiple devices
- [ ] Performance profiling
- [ ] Security audit
- [ ] App store assets (screenshots, description)

---

## 📞 Support & Documentation

Untuk pertanyaan atau bantuan implementasi, silakan hubungi tim development atau buat issue di repository.

**Happy Coding! 🚀**
