# StockFlow - Warehouse Management API

API lengkap untuk sistem manajemen gudang (warehouse management system) menggunakan Laravel 12 dengan fitur-fitur modern.

## 🚀 Fitur Utama

- ✅ **Multi-Warehouse Support** - Kelola multiple gudang dalam satu sistem
- ✅ **Product Management** - Kelola produk dengan kategori dan supplier
- ✅ **Product Image Upload** - Upload gambar produk (JPEG, PNG, GIF - max 2MB)
- ✅ **QR Code Generation** - Generate QR code untuk setiap produk (SVG format)
- ✅ **QR Code Scanner** - Scan QR code untuk lookup produk instant
- ✅ **Stock Tracking** - Real-time tracking pergerakan stok
- ✅ **Purchase Order Workflow** - Draft → Pending → Approved → Completed
- ✅ **Sales Order Workflow** - Draft → Confirmed → Shipped → Delivered
- ✅ **Stock Reservation** - Reserve stok untuk sales order pending
- ✅ **Stock Adjustment** - Koreksi stok (stock opname)
- ✅ **Transfer antar Gudang** - Move stock between warehouses
- ✅ **Dashboard & Analytics** - Statistik dan insight bisnis
- ✅ **User Management** - Admin dapat CRUD users, reset password, toggle status
- ✅ **Role-Based Access** - Admin, Manager, Staff
- ✅ **RESTful API** - JSON response format
- ✅ **Authentication** - Laravel Sanctum token-based auth

## 📋 Requirements

- PHP >= 8.2
- Composer
- SQLite/MySQL/PostgreSQL
- Laravel 12

## 🛠️ Installation

### 1. Clone Repository

```bash
git clone <repository-url>
cd apistockflow
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` file sesuai kebutuhan database Anda.

### 4. Run Migrations & Seeders

```bash
php artisan migrate:fresh --seed
```

### 5. Start Development Server

```bash
php artisan serve
```

API akan tersedia di `http://localhost:8000/api`

## 👥 Default User Credentials

Setelah menjalankan seeder, Anda dapat login dengan kredensial berikut:

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@stockflow.com | password |
| Manager | manager@stockflow.com | password |
| Staff | staff@stockflow.com | password |

## 📚 API Documentation

### Base URL

```
http://localhost:8000/api
```

### Authentication

API menggunakan Laravel Sanctum untuk authentication. Setelah login, gunakan token pada header setiap request:

```
Authorization: Bearer {your-token}
```

---

## ⚡ Rate Limiting

Untuk melindungi backend dari beban berlebihan, API ini menggunakan **rate limiting** berdasarkan IP address dan user authentication.

### Rate Limit Configuration

| Endpoint Type | Rate Limit | Time Window |
|---------------|------------|-------------|
| **Public Endpoints** (Login, Register) | 5 requests | per minute |
| **Auth Endpoints** (Logout, Me, Profile) | 60 requests | per minute |
| **Read Operations** (GET) | 60 requests | per minute |
| **Write Operations** (POST, PUT) | 30 requests | per minute |
| **Delete Operations** (DELETE) | 10 requests | per minute |
| **Upload Operations** (Image Upload) | 10 requests | per minute |

### Rate Limit Headers

Setiap API response akan menyertakan header informasi rate limit:

```http
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 45
X-RateLimit-Reset: 1704124800
```

**Penjelasan:**
- `X-RateLimit-Limit`: Maximum requests allowed dalam time window
- `X-RateLimit-Remaining`: Sisa requests yang masih bisa digunakan
- `X-RateLimit-Reset`: Unix timestamp kapan rate limit akan reset

### When Rate Limit Exceeded

Jika rate limit tercapai, API akan return **HTTP 429 Too Many Requests**:

```json
{
  "message": "Too Many Requests. Please try again later.",
  "retry_after": 60
}
```

**Response Headers:**
```http
HTTP/1.1 429 Too Many Requests
Retry-After: 60
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 0
X-RateLimit-Reset: 1704124860
```

### Implementation Guide (Laravel)

Untuk mengimplementasikan rate limiting di Laravel, tambahkan ke `routes/api.php`:

```php
// Public endpoints - stricter limits
Route::middleware('throttle:5,1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

// Authenticated endpoints
Route::middleware(['auth:sanctum'])->group(function () {
    // Auth operations
    Route::middleware('throttle:60,1')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
        Route::put('/profile', [AuthController::class, 'updateProfile']);
    });
    
    // Read operations
    Route::middleware('throttle:60,1')->group(function () {
        Route::get('/products', [ProductController::class, 'index']);
        Route::get('/categories', [CategoryController::class, 'index']);
        // ... other GET endpoints
    });
    
    // Write operations
    Route::middleware('throttle:30,1')->group(function () {
        Route::post('/products', [ProductController::class, 'store']);
        Route::put('/products/{id}', [ProductController::class, 'update']);
        // ... other POST/PUT endpoints
    });
    
    // Delete operations
    Route::middleware('throttle:10,1')->group(function () {
        Route::delete('/products/{id}', [ProductController::class, 'destroy']);
        // ... other DELETE endpoints
    });
    
    // Upload operations
    Route::middleware('throttle:10,1')->group(function () {
        Route::post('/products/{id}/upload-image', [ProductController::class, 'uploadImage']);
    });
});
```

### Best Practices for Clients

1. **Monitor Headers**: Selalu cek `X-RateLimit-Remaining` untuk menghindari hitting limit
2. **Implement Retry Logic**: Gunakan exponential backoff saat menerima 429
3. **Cache Responses**: Cache data yang jarang berubah untuk mengurangi API calls
4. **Batch Operations**: Combine multiple operations jika memungkinkan

**Contoh Retry Logic:**
```javascript
async function callApiWithRetry(url, options, maxRetries = 3) {
  for (let i = 0; i < maxRetries; i++) {
    const response = await fetch(url, options);
    
    if (response.status === 429) {
      const retryAfter = response.headers.get('Retry-After') || 60;
      await new Promise(resolve => setTimeout(resolve, retryAfter * 1000));
      continue;
    }
    
    return response;
  }
  throw new Error('Max retries exceeded');
}
```

---

## 🔐 Authentication Endpoints

### Register

```http
POST /register
```

**Request Body:**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123",
  "phone": "081234567890",
  "role": "staff"
}
```

**Response:**
```json
{
  "success": true,
  "message": "User registered successfully",
  "data": {
    "user": {...},
    "access_token": "1|abc...",
    "token_type": "Bearer"
  }
}
```

### Login

```http
POST /login
```

**Request Body:**
```json
{
  "email": "admin@stockflow.com",
  "password": "password"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "user": {
      "id": 1,
      "name": "Admin User",
      "email": "admin@stockflow.com",
      "role": "admin"
    },
    "access_token": "1|abc...",
    "token_type": "Bearer"
  }
}
```

### Logout

```http
POST /logout
```

### Get Current User

```http
GET /me
```

---

## 📦 Product Endpoints

### List Products

```http
GET /products
GET /products?search=laptop
GET /products?category_id=1
GET /products?supplier_id=1
```

### Create Product

```http
POST /products
```

**Request Body:**
```json
{
  "category_id": 1,
  "supplier_id": 1,
  "sku": "ELEC-LAP-002",
  "name": "Laptop Dell XPS 15",
  "description": "High performance laptop",
  "unit": "pcs",
  "min_stock": 5,
  "max_stock": 50,
  "purchase_price": 20000000,
  "selling_price": 25000000,
  "is_active": true
}
```

### Get Product Detail

```http
GET /products/{id}
```

### Update Product

```http
PUT /products/{id}
```

### Delete Product

```http
DELETE /products/{id}
```

### Get Low Stock Products

```http
GET /products-low-stock
```

### Get Product Stock History

```http
GET /products/{id}/stock-history
```

### Upload Product Image

```http
POST /products/{id}/upload-image
```

**Request:** Multipart form-data
- `image` (file): Image file (jpeg, png, jpg, gif - max 2MB)

**Response:**
```json
{
  "success": true,
  "message": "Product image uploaded successfully",
  "data": {
    "image_path": "products/abc123.jpg",
    "image_url": "http://localhost:8000/storage/products/abc123.jpg"
  }
}
```

### Generate Product QR Code

```http
GET /products/{id}/qr-code
```

**Response:** SVG image file

QR code contains JSON data:
```json
{
  "type": "product",
  "id": 1,
  "sku": "ELEC-LAP-001",
  "name": "Laptop ASUS ROG"
}
```

**Usage:**
```html
<!-- Frontend dapat menampilkan QR code langsung -->
<img src="http://localhost:8000/api/products/1/qr-code?token=YOUR_TOKEN" alt="Product QR Code">
```

### Scan/Lookup Product by QR Code

```http
POST /products/scan-qr
```

**Request Body:**
```json
{
  "qr_data": "{\"type\":\"product\",\"id\":1,\"sku\":\"ELEC-LAP-001\",\"name\":\"Laptop ASUS ROG\"}"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Product found",
  "data": {
    "product": {...},
    "total_stock": 140,
    "stock_by_warehouse": [
      {
        "warehouse_id": 1,
        "warehouse_name": "Warehouse Jakarta Pusat",
        "quantity": 70,
        "available_quantity": 70
      }
    ]
  }
}
```

---

## 🏢 Warehouse Endpoints

### List Warehouses

```http
GET /warehouses
```

### Create Warehouse

```http
POST /warehouses
```

**Request Body:**
```json
{
  "name": "Warehouse Surabaya",
  "code": "WH-SBY-01",
  "address": "Jl. Raya Surabaya No. 100",
  "city": "Surabaya",
  "country": "Indonesia",
  "manager_name": "Rizky Pratama",
  "phone": "031123456",
  "is_active": true
}
```

### Get Warehouse Stocks

```http
GET /warehouses/{id}/stocks
```

---

## 📥 Purchase Order Endpoints

### List Purchase Orders

```http
GET /purchase-orders
GET /purchase-orders?status=pending
GET /purchase-orders?supplier_id=1
```

### Create Purchase Order

```http
POST /purchase-orders
```

**Request Body:**
```json
{
  "supplier_id": 1,
  "warehouse_id": 1,
  "order_date": "2026-01-01",
  "expected_delivery_date": "2026-01-10",
  "notes": "Urgent order",
  "items": [
    {
      "product_id": 1,
      "quantity": 10,
      "unit_price": 15000000
    },
    {
      "product_id": 2,
      "quantity": 20,
      "unit_price": 10000000
    }
  ]
}
```

### Approve Purchase Order

```http
POST /purchase-orders/{id}/approve
```

### Complete Purchase Order (Stock IN)

```http
POST /purchase-orders/{id}/complete
```

This will add stock to the warehouse.

### Cancel Purchase Order

```http
POST /purchase-orders/{id}/cancel
```

---

## 📤 Sales Order Endpoints

### List Sales Orders

```http
GET /sales-orders
GET /sales-orders?status=confirmed
```

### Create Sales Order

```http
POST /sales-orders
```

**Request Body:**
```json
{
  "customer_name": "PT ABC Indonesia",
  "customer_email": "contact@abc.com",
  "customer_phone": "021123456",
  "warehouse_id": 1,
  "order_date": "2026-01-01",
  "delivery_date": "2026-01-05",
  "notes": "Deliver before 5 PM",
  "items": [
    {
      "product_id": 1,
      "quantity": 5,
      "unit_price": 18000000
    }
  ]
}
```

### Confirm Sales Order (Reserve Stock)

```http
POST /sales-orders/{id}/confirm
```

Stock akan direserve (tidak bisa dijual ke order lain).

### Ship Sales Order (Stock OUT)

```http
POST /sales-orders/{id}/ship
```

Stock akan dikurangi dari warehouse.

### Deliver Sales Order

```http
POST /sales-orders/{id}/deliver
```

### Cancel Sales Order

```http
POST /sales-orders/{id}/cancel
```

Reserved stock akan direlease.

---

## 📊 Stock Movement Endpoints

### List Stock Movements

```http
GET /stock-movements
GET /stock-movements?type=IN
GET /stock-movements?product_id=1
GET /stock-movements?warehouse_id=1
```

### Transfer Stock Between Warehouses

```http
POST /stock-movements/transfer
```

**Request Body:**
```json
{
  "product_id": 1,
  "from_warehouse_id": 1,
  "to_warehouse_id": 2,
  "quantity": 10,
  "notes": "Rebalancing stock"
}
```

---

## 🔧 Stock Adjustment Endpoints

### Create Stock Adjustment

```http
POST /stock-adjustments
```

**Request Body:**
```json
{
  "product_id": 1,
  "warehouse_id": 1,
  "type": "increase",
  "quantity": 5,
  "reason": "Stock opname correction",
  "notes": "Found missing items in warehouse"
}
```

Type: `increase` atau `decrease`

---

## 📈 Dashboard Endpoints

### Get Dashboard Statistics

```http
GET /dashboard/stats
```

**Response:**
```json
{
  "success": true,
  "data": {
    "products": {
      "total": 100,
      "low_stock": 10,
      "out_of_stock": 2
    },
    "warehouses": {
      "total": 3,
      "total_stock_value": 500000000
    },
    "purchase_orders": {
      "pending": 5,
      "completed_this_month": 20
    },
    "sales_orders": {
      "confirmed": 8,
      "delivered_this_month": 15
    }
  }
}
```

### Get Recent Stock Movements

```http
GET /dashboard/recent-movements
```

### Get Low Stock Products

```http
GET /dashboard/low-stock-products
```

---

## 🗂️ Database Schema

### Main Tables

- **users** - User authentication & roles
- **categories** - Product categories (nested support)
- **suppliers** - Supplier information
- **warehouses** - Warehouse locations
- **products** - Product catalog
- **product_stocks** - Stock quantity per warehouse per product
- **stock_movements** - Audit trail of all stock changes
- **purchase_orders** - Purchase order headers
- **purchase_order_items** - Purchase order line items
- **sales_orders** - Sales order headers
- **sales_order_items** - Sales order line items
- **stock_adjustments** - Stock corrections/adjustments

---

## 🔒 Role-Based Access Control

| Feature | Admin | Manager | Staff |
|---------|-------|---------|-------|
| View Data | ✅ | ✅ | ✅ |
| Create/Update | ✅ | ✅ | ❌ |
| Delete | ✅ | ❌ | ❌ |
| Approve PO | ✅ | ✅ | ❌ |
| User Management | ✅ | ❌ | ❌ |

---

## 📝 Response Format

Semua response menggunakan format JSON konsisten:

### Success Response

```json
{
  "success": true,
  "message": "Operation successful",
  "data": {...}
}
```

### Error Response

```json
{
  "success": false,
  "message": "Error message",
  "errors": {...}
}
```

### Validation Error

```json
{
  "message": "The given data was invalid.",
  "errors": {
    "email": ["The email field is required."]
  }
}
```

---

## 🧪 Testing

### Test Authentication

```bash
# Register
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password",
    "password_confirmation": "password"
  }'

# Login
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@stockflow.com",
    "password": "password"
  }'
```

### Test Protected Endpoint

```bash
curl -X GET http://localhost:8000/api/products \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

---

## 🚧 Development

### Refresh Database

```bash
php artisan migrate:fresh --seed
```

### Clear Cache

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

---

## 📄 License

MIT License

---

## 👨‍💻 Author

Built with ❤️ by Your Team

---

## 🆘 Support

For issues and questions, please create an issue in the repository.
