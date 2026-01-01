# API Routes Reference - StockFlow

Quick reference untuk semua API endpoints yang tersedia.

**Base URL:** `http://localhost:8000/api`

**Legend:**
- 🔓 Public - Tidak perlu authentication
- 🔐 Auth - Perlu authentication token
- 👑 Admin - Hanya admin yang bisa akses

---

## 🔓 Authentication (Public)

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/register` | Register user baru |
| POST | `/login` | Login dan dapatkan token |

---

## 🔐 Authentication (Protected)

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/logout` | Logout dan hapus token |
| GET | `/me` | Get user profile saat ini |
| PUT | `/profile` | Update profile user |

---

## 🔐 Dashboard

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/dashboard/stats` | Dashboard statistics |
| GET | `/dashboard/recent-movements` | Recent stock movements (20 terakhir) |
| GET | `/dashboard/low-stock-products` | Produk dengan stok rendah |

---

## 🔐 Categories

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/categories` | List semua kategori |
| POST | `/categories` | Buat kategori baru |
| GET | `/categories/{id}` | Detail kategori |
| PUT | `/categories/{id}` | Update kategori |
| DELETE | `/categories/{id}` | Hapus kategori |
| GET | `/categories/{id}/products` | List produk dalam kategori |

---

## 🔐 Suppliers

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/suppliers` | List semua supplier |
| POST | `/suppliers` | Buat supplier baru |
| GET | `/suppliers/{id}` | Detail supplier |
| PUT | `/suppliers/{id}` | Update supplier |
| DELETE | `/suppliers/{id}` | Hapus supplier |

---

## 🔐 Products

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/products` | List semua produk (support search, filter) |
| POST | `/products` | Buat produk baru |
| GET | `/products/{id}` | Detail produk + stock info |
| PUT | `/products/{id}` | Update produk |
| DELETE | `/products/{id}` | Hapus produk |
| GET | `/products-low-stock` | Produk dengan stok rendah |
| GET | `/products/{id}/stock-history` | Riwayat pergerakan stok produk |
| POST | `/products/{id}/upload-image` | Upload gambar produk |
| GET | `/products/{id}/qr-code` | Generate QR code (SVG) |
| POST | `/products/scan-qr` | Scan QR code untuk lookup produk |

---

## 🔐 Warehouses

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/warehouses` | List semua warehouse |
| POST | `/warehouses` | Buat warehouse baru |
| GET | `/warehouses/{id}` | Detail warehouse |
| PUT | `/warehouses/{id}` | Update warehouse |
| DELETE | `/warehouses/{id}` | Hapus warehouse |
| GET | `/warehouses/{id}/stocks` | List stok di warehouse |

---

## 🔐 Stock Movements

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/stock-movements` | List semua stock movements |
| GET | `/stock-movements/{id}` | Detail stock movement |
| POST | `/stock-movements/transfer` | Transfer stok antar warehouse |

---

## 🔐 Purchase Orders

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/purchase-orders` | List semua PO |
| POST | `/purchase-orders` | Buat PO baru |
| GET | `/purchase-orders/{id}` | Detail PO + items |
| PUT | `/purchase-orders/{id}` | Update PO (hanya draft) |
| DELETE | `/purchase-orders/{id}` | Hapus PO (hanya draft) |
| POST | `/purchase-orders/{id}/approve` | Approve PO |
| POST | `/purchase-orders/{id}/complete` | Complete PO (stok masuk) |
| POST | `/purchase-orders/{id}/cancel` | Cancel PO |

---

## 🔐 Sales Orders

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/sales-orders` | List semua SO |
| POST | `/sales-orders` | Buat SO baru |
| GET | `/sales-orders/{id}` | Detail SO + items |
| PUT | `/sales-orders/{id}` | Update SO (hanya draft) |
| DELETE | `/sales-orders/{id}` | Hapus SO (hanya draft) |
| POST | `/sales-orders/{id}/confirm` | Confirm SO (reserve stok) |
| POST | `/sales-orders/{id}/ship` | Ship SO (stok keluar) |
| POST | `/sales-orders/{id}/deliver` | Deliver SO |
| POST | `/sales-orders/{id}/cancel` | Cancel SO (release stok) |

---

## 🔐 Stock Adjustments

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/stock-adjustments` | List semua adjustment |
| POST | `/stock-adjustments` | Buat adjustment (auto apply) |
| GET | `/stock-adjustments/{id}` | Detail adjustment |

---

## 👑 User Management (Admin Only)

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/users` | List semua users |
| POST | `/users` | Buat user baru |
| GET | `/users/{id}` | Detail user + statistik |
| PUT | `/users/{id}` | Update user |
| DELETE | `/users/{id}` | Hapus user |
| POST | `/users/{id}/reset-password` | Reset password user |
| POST | `/users/{id}/toggle-status` | Toggle active/inactive |
| GET | `/users/{id}/activity` | Lihat aktivitas user |

---

## 📋 Query Parameters

### Common Filters

**Products:**
```
?search=laptop
?category_id=1
?supplier_id=1
?is_active=true
```

**Users:**
```
?search=admin
?role=manager
?is_active=true
```

**Orders:**
```
?status=pending
?supplier_id=1
?warehouse_id=1
```

### Pagination

```
?page=1
?per_page=15
```

---

## 🔑 Authentication Header

Semua protected endpoints memerlukan header:

```
Authorization: Bearer {your-token-here}
```

**Contoh:**
```bash
curl -X GET http://localhost:8000/api/products \
  -H "Authorization: Bearer 1|abc123..."
```

---

## ⚡ Rate Limiting

API ini menggunakan rate limiting untuk melindungi backend dari beban berlebihan.

### Rate Limits

| Endpoint Type | Rate Limit | Window |
|---------------|------------|--------|
| Public (Login, Register) | 5 requests | per minute |
| Authentication (Logout, Me, Profile) | 60 requests | per minute |
| Read Operations (GET) | 60 requests | per minute |
| Write Operations (POST, PUT) | 30 requests | per minute |
| Delete Operations (DELETE) | 10 requests | per minute |
| Upload Operations (Image, QR) | 10 requests | per minute |

### Rate Limit Headers

Setiap response akan menyertakan header informasi rate limit:

```
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 45
X-RateLimit-Reset: 1704124800
```

### Rate Limit Exceeded Response

Jika limit tercapai, API akan return HTTP 429:

```json
{
  "message": "Too Many Requests. Please try again later.",
  "retry_after": 60
}
```

**Header tambahan saat limit tercapai:**
```
Retry-After: 60
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 0
X-RateLimit-Reset: 1704124800
```

---

## 📊 Response Format

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
  "message": "Error message"
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

## 🚀 Quick Start Examples

### 1. Login
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@stockflow.com","password":"password"}'
```

### 2. Get Products
```bash
curl -X GET http://localhost:8000/api/products \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### 3. Create Product
```bash
curl -X POST http://localhost:8000/api/products \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "category_id": 1,
    "sku": "PROD-001",
    "name": "New Product",
    "unit": "pcs",
    "min_stock": 10,
    "purchase_price": 100000,
    "selling_price": 150000
  }'
```

### 4. Upload Product Image
```bash
curl -X POST http://localhost:8000/api/products/1/upload-image \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -F "image=@/path/to/image.jpg"
```

### 5. Get QR Code
```bash
curl -X GET http://localhost:8000/api/products/1/qr-code \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -o product-qr.svg
```

---

## 📝 Total Endpoints

- **Public:** 2
- **Auth Required:** 53
- **Admin Only:** 8
- **Total:** 63 endpoints

---

## 🔗 Related Documentation

- [Complete API Documentation](README.md) - Full documentation with examples
- [Database Schema](walkthrough.md) - Database structure and relationships
- [Implementation Plan](implementation_plan.md) - Development roadmap

---

**Last Updated:** 2026-01-01
**API Version:** v1
