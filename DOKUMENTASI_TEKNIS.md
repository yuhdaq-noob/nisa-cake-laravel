# DOKUMENTASI TEKNIS

## Sistem Manajemen Inventori Toko Kue Berbasis Bill of Materials (BOM)

**NISA-APP — Point of Sale & Inventory Management System**

---

### Informasi Dokumen

| Atribut       | Keterangan                                    |
| ------------- | --------------------------------------------- |
| Nama Aplikasi | NISA-APP (Nisa Cake Management System)        |
| Versi         | 1.0.0                                         |
| Tanggal Rilis | 12 Februari 2026                              |
| Jenis Dokumen | Spesifikasi Teknis & Dokumentasi Implementasi |
| Tujuan        | Dokumentasi untuk Tugas Akhir/Skripsi         |

---

## 📖 Daftar Isi

### I. PENDAHULUAN

1. [Latar Belakang](#1-latar-belakang)
2. [Rumusan Masalah](#2-rumusan-masalah)
3. [Tujuan Penelitian](#3-tujuan-penelitian)
4. [Ruang Lingkup](#4-ruang-lingkup)
5. [Manfaat Penelitian](#5-manfaat-penelitian)

### II. LANDASAN TEORI

6. [Konsep Bill of Materials (BOM)](#6-konsep-bill-of-materials-bom)
7. [Sistem Manajemen Inventori](#7-sistem-manajemen-inventori)
8. [Stack Teknologi](#8-stack-teknologi)

### III. ANALISIS DAN PERANCANGAN

9. [Analisis Sistem](#9-analisis-sistem)
10. [Spesifikasi Database](#10-spesifikasi-database)
11. [Arsitektur Aplikasi](#11-arsitektur-aplikasi)
12. [Perancangan Antarmuka](#12-perancangan-antarmuka)

### IV. IMPLEMENTASI

13. [Alur Bisnis Proses](#13-alur-bisnis-proses)
14. [API Endpoints](#14-api-endpoints)
15. [Validasi & Error Handling](#15-validasi--error-handling)
16. [Fitur Utama Yang Diimplementasikan](#16-fitur-utama-yang-diimplementasikan)

### V. PENGUJIAN & DEPLOYMENT

17. [Testing](#17-testing)
18. [Setup & Installation](#18-setup--installation)
19. [Deployment](#19-deployment)

### VI. PENUTUP

20. [Kesimpulan](#20-kesimpulan)
21. [FAQ & Troubleshooting](#21-faq--troubleshooting)
22. [Referensi](#22-referensi)

---

## I. PENDAHULUAN

### 1. Latar Belakang

Usaha mikro, kecil, dan menengah (UMKM) di bidang kuliner, khususnya toko kue, menghadapi tantangan dalam mengelola inventori bahan baku secara efisien. Permasalahan yang sering terjadi meliputi:

- **Kesulitan pelacakan stok real-time**: Pemilik toko kesulitan mengetahui jumlah stok bahan baku yang tersedia secara akurat
- **Kalkulasi kebutuhan bahan manual**: Perhitungan kebutuhan bahan untuk setiap produk masih dilakukan secara manual, rentan terhadap kesalahan
- **Pencatatan tidak terstruktur**: Riwayat transaksi dan perubahan stok tidak terdokumentasi dengan baik
- **Analisis profit tidak akurat**: Kesulitan menghitung Harga Pokok Produksi (HPP) dan laba bersih per produk

Sistem manajemen inventori berbasis **Bill of Materials (BOM)** menawarkan solusi untuk masalah tersebut dengan mengintegrasikan resep produk (BOM) dengan sistem Point of Sale (POS). Setiap kali pesanan dibuat, sistem otomatis menghitung kebutuhan bahan baku dan mengurangi stok secara real-time menggunakan database transactions untuk menjamin konsistensi data.

### 2. Rumusan Masalah

Berdasarkan latar belakang di atas, rumusan masalah penelitian ini adalah:

1. Bagaimana merancang sistem manajemen inventori yang dapat mengotomatisasi perhitungan kebutuhan bahan baku berdasarkan Bill of Materials (BOM)?
2. Bagaimana mengimplementasikan mekanisme pengurangan stok otomatis yang aman dari race condition dan inkonsistensi data?
3. Bagaimana menyediakan sistem pelaporan yang akurat untuk analisis profit dan HPP per produk?

### 3. Tujuan Penelitian

Penelitian ini bertujuan untuk:

1. **Merancang dan mengimplementasikan** sistem manajemen inventori berbasis BOM untuk toko kue
2. **Mengotomatisasi proses perhitungan** kebutuhan bahan baku dan pengurangan stok
3. **Menyediakan audit trail lengkap** untuk pelacakan perubahan stok dan harga bahan
4. **Menghasilkan laporan penjualan** dengan kalkulasi HPP dan profit yang akurat
5. **Menerapkan best practices** dalam pengembangan perangkat lunak (clean architecture, type safety, transaction safety)

### 4. Ruang Lingkup

Aplikasi yang dikembangkan memiliki ruang lingkup sebagai berikut:

**Batasan Sistem:**

- Sistem berbasis web dengan arsitektur monolitik (Laravel full-stack)
- Target pengguna: Pemilik toko kue dan kasir
- Fokus pada manajemen inventori, POS, dan pelaporan

**Fitur Yang Dikembangkan:**

- ✅ Manajemen bahan baku (CRUD materials)
- ✅ Manajemen produk dengan BOM
- ✅ Point of Sale (POS) untuk kasir
- ✅ Pengurangan stok otomatis saat order
- ✅ Pencatatan riwayat stok (audit trail)
- ✅ Pencatatan riwayat harga bahan
- ✅ Laporan penjualan dengan analisis profit
- ✅ Notifikasi stok minimum
- ✅ User authentication

**Fitur Yang Tidak Dikembangkan:**

- ❌ Sistem pembayaran online/payment gateway
- ❌ Integrasi dengan perangkat hardware POS (barcode scanner, cash drawer)
- ❌ Manajemen multi-cabang
- ❌ CRM (Customer Relationship Management)

### 5. Manfaat Penelitian

**Manfaat Praktis:**

- Meningkatkan efisiensi pengelolaan inventori toko kue
- Mengurangi kesalahan perhitungan manual kebutuhan bahan
- Menyediakan data akurat untuk pengambilan keputusan bisnis

**Manfaat Akademis:**

- Memberikan studi kasus implementasi BOM dalam sistem inventori
- Mendemonstrasikan penerapan clean architecture pada aplikasi web
- Dokumentasi lengkap untuk referensi pengembangan sistem sejenis

---

## II. LANDASAN TEORI

### 6. Konsep Bill of Materials (BOM)

**Bill of Materials (BOM)** adalah daftar komprehensif dari bahan baku, komponen, dan sub-assembly yang diperlukan untuk membuat produk jadi. Dalam konteks toko kue:

- **Product**: Produk jadi (e.g., Kue Tart Bolu 14)
- **Materials**: Bahan baku (e.g., Tepung, Telur, Gula)
- **BOM Entry**: Formula/resep yang mendefinisikan jumlah material per produk

**Contoh BOM:**

```
Kue Tart Bolu 14:
- Tepung Terigu: 120 gram
- Telur: 2 butir
- Gula Pasir: 90 gram
- Mentega: 80 gram
- Susu Cair: 50 ml
```

**Fungsi BOM dalam Sistem:**

1. Otomasi perhitungan kebutuhan bahan saat order
2. Validasi ketersediaan stok sebelum menerima pesanan
3. Kalkulasi HPP (Harga Pokok Produksi) per produk

### 7. Sistem Manajemen Inventori

Sistem manajemen inventori adalah sistem informasi yang dirancang untuk melacak dan mengelola stok barang. Komponen utama:

- **Stock Tracking**: Pelacakan stok masuk, keluar, dan saldo
- **Stock Valuation**: Penilaian nilai stok (FIFO, LIFO, Average)
- **Reorder Point**: Titik pemesanan ulang saat stok mencapai minimum
- **Audit Trail**: Jejak rekam perubahan untuk akuntabilitas

**Implementasi dalam NISA-APP:**

- Real-time stock tracking melalui proses transaksi (order/restock/adjustment) yang tercatat dan konsisten
- Stock logs untuk audit trail lengkap
- Min stock level untuk notifikasi reorder
- Price logs untuk pelacakan perubahan harga

### 8. Stack Teknologi

Aplikasi NISA-APP dibangun menggunakan teknologi modern dengan pertimbangan:

**Backend Framework:**

- **PHP 8.2+** - Bahasa pemrograman dengan type hints & enums untuk type safety
- **Laravel 12.x** - Full-stack web framework dengan ekosistem lengkap
    - Eloquent ORM untuk database abstraction
    - Blade templating engine
    - Built-in authentication & authorization
    - Database migration & seeding
- **Laravel Sanctum 4.0** - API authentication untuk future mobile app integration
- **MySQL 8.x** - Relational database untuk deployment dan penggunaan harian (dikelola via DataGrip)
- _(Opsional)_ **SQLite** - Alternatif untuk demo/quick start tanpa setup server database

**Frontend Stack:**

- **Vite 7.x** - Modern build tool dengan hot module reload
- **Tailwind CSS 4.0** - Utility-first CSS framework untuk rapid UI development
- **Axios 1.11** - Promise-based HTTP client
- **Vanilla JavaScript** - Tanpa framework overhead untuk performance optimal

**Development & Testing Tools:**

- **PHPUnit 11.5** - Unit & feature testing framework
- **Laravel Pint 1.24** - Opinionated code style fixer (Laravel standard)
- **Composer 2+** - PHP dependency manager
- **Node.js LTS** - JavaScript runtime untuk build tools

**Alasan Pemilihan Stack:**

1. **Laravel**: Produktivitas tinggi, dokumentasi lengkap, komunitas besar
2. **MySQL**: Stabil, umum digunakan, mudah dikelola (DataGrip), dan cocok untuk data transaksi
3. **Tailwind CSS**: Konsistensi desain, kustomisasi mudah, bundle size kecil
4. **Vite**: Build time cepat, developer experience superior

---

## III. ANALISIS DAN PERANCANGAN

### 9. Analisis Sistem

**Analisis Kebutuhan Pengguna:**

Berdasarkan wawancara dengan pemilik toko kue (Nisa Cake), kebutuhan sistem mencakup:

1. **Kebutuhan Fungsional:**
    - Pencatatan bahan baku dengan stok real-time
    - Pembuatan resep produk (BOM)
    - Pemrosesan pesanan dengan perhitungan otomatis
    - Laporan penjualan dan profit
    - Notifikasi stok menipis

2. **Kebutuhan Non-Fungsional:**
    - **Performance**: Response time < 500ms untuk operasi CRUD
    - **Reliability**: Uptime 99% dengan data consistency guarantee
    - **Usability**: Interface intuitif untuk pengguna non-teknis
    - **Scalability**: Dapat menangani 1000+ transaksi per bulan
    - **Security**: Autentikasi user, validasi input, SQL injection prevention

**Analisis Proses Bisnis Eksisting:**

_Sebelum Sistem (Manual):_

```
Pesanan Masuk → Cek Stok Manual → Hitung Kebutuhan Bahan →
Catat di Buku → Kurangi Stok → Catat Penjualan → Hitung Profit Manual
```

_Setelah Sistem (Otomatis):_

```
Pesanan Masuk via POS → Sistem Hitung BOM → Validasi Stok Otomatis →
Kurangi Stok + Log → Generate Laporan Real-time
```

**Use Case Diagram:**

```
┌──────────────────────────────────────────────────────┐
│                     NISA-APP                         │
├──────────────────────────────────────────────────────┤
│                                                      │
│  Kasir                        Owner/Manager         │
│   ├── Buat Pesanan              ├── Kelola Material │
│   ├── Lihat Produk              ├── Kelola Produk   │
│   └── Cetak Nota                ├── Lihat Laporan   │
│                                 ├── Update Harga    │
│                                 └── Kelola User     │
└──────────────────────────────────────────────────────┘
```

### 10. Spesifikasi Database

### 10. Spesifikasi Database

**Entity Relationship Diagram (ERD):**

```
┌─────────────┐       ┌──────────────────┐       ┌────────────┐
│   Product   │───────│ Product_Materials│───────│  Material  │
│             │ 1:N   │     (BOM Table)  │ N:1   │            │
│ - id        │       │ - product_id     │       │ - id       │
│ - name      │       │ - material_id    │       │ - name     │
│ - price     │       │ - qty_needed     │       │ - unit     │
└──────┬──────┘       └──────────────────┘       │ - stock    │
       │                                           └─────┬──────┘
       │ 1:N                                             │ 1:N
       │                                                 │
┌──────┴──────┐                                  ┌───────┴────────┐
│ Order_Items │                                  │   Stock_Logs   │
│             │ N:1                              │                │
│ - order_id  ├─────┐                            │ - material_id  │
│ - product_id│     │                            │ - type         │
│ - quantity  │     │                            │ - amount       │
└─────────────┘     │                            └────────────────┘
                    │ 1:N
              ┌─────┴─────┐
              │   Order   │
              │           │
              │ - id      │
              │ - customer│
              │ - total   │
              └───────────┘
```

**Tabel Utama (Domain Models):**

| Tabel                 | Kolom Utama                                                                                                               | Fungsi                       |
| --------------------- | ------------------------------------------------------------------------------------------------------------------------- | ---------------------------- |
| `materials`           | id, name, unit, unit_baku, price_per_unit, price_per_unit_baku, current_stock, min_stock_level                            | Manajemen bahan baku & harga |
| `products`            | id, name, selling_price, production_cost, description                                                                     | Master produk kue            |
| `product_materials`   | product_id, material_id, quantity_needed                                                                                  | BOM (resep) per produk       |
| `orders`              | id, customer_name, status, total_price, total_hpp                                                                         | Transaksi penjualan          |
| `order_items`         | order_id, product_id, quantity, price_per_unit                                                                            | Detail item per pesanan      |
| `stock_logs`          | material_id, type, amount, description                                                                                    | Audit trail perubahan stok   |
| `material_price_logs` | material_id, user_id, old_price_per_unit, new_price_per_unit, old_price_per_unit_baku, new_price_per_unit_baku, unit_baku | Audit trail perubahan harga  |
| `users`               | id, name, username, email, password                                                                                       | User authentication          |

### Relasi Utama

```
Product ──┬──> Product_Materials ──┬──> Material
          │                         │
          └──> Order_Items ────────┘

Order ────> Order_Items ────> Product

Material ──> Stock_Logs
```

### Enum & Status

| Enum           | Nilai                         | Deskripsi             |
| -------------- | ----------------------------- | --------------------- |
| `OrderStatus`  | pending, completed, cancelled | Status proses pesanan |
| `StockLogType` | in, out, adjustment           | Tipe perubahan stok   |

---

### 11. Arsitektur Aplikasi

**Pola Arsitektur: Layered Architecture (Clean Architecture)**

Aplikasi menggunakan **Layered Architecture** untuk separation of concerns:

```
┌─────────────────────────────────────────────────────────┐
│ Presentation Layer (routes/web.php, routes/api.php)    │
│ - Routing & HTTP handling                              │
└────────────────────┬────────────────────────────────────┘
                     ↓
┌─────────────────────────────────────────────────────────┐
│ Controller Layer (app/Http/Controllers)                 │
│ - Request handling & validation (FormRequests)          │
│ - Response formatting (API Resources)                   │
└────────────────────┬────────────────────────────────────┘
                     ↓
┌─────────────────────────────────────────────────────────┐
│ Service Layer (app/Services)                            │
│ - Business logic & orchestration                        │
│ - OrderService: BOM calculation & stock validation      │
│ - StockService: Stock management & logging              │
└────────────────────┬────────────────────────────────────┘
                     ↓
┌─────────────────────────────────────────────────────────┐
│ Data Access Layer (app/Models)                          │
│ - Eloquent ORM models                                   │
│ - Database queries & relationships                      │
└────────────────────┬────────────────────────────────────┘
                     ↓
┌─────────────────────────────────────────────────────────┐
│ Database Layer (MySQL)                                  │
│ - Data persistence                                      │
└─────────────────────────────────────────────────────────┘
```

**Keuntungan Layered Architecture:**

1. **Maintainability**: Setiap layer memiliki tanggung jawab spesifik
2. **Testability**: Layer dapat ditest secara independen dengan mocking
3. **Reusability**: Service layer dapat dipanggil dari berbagai controller
4. **Scalability**: Mudah untuk menambah fitur tanpa mengubah struktur existing

**Dependency Injection:**

```php
class OrderController extends Controller
{
    public function __construct(
        private OrderService $orderService  // DI Container otomatis inject
    ) {}
}
```

**File Structure (Detail):**

```
┌─────────────────────────────────────────┐
│ Routes (routes/api.php, routes/web.php) │
└────────────────┬────────────────────────┘
                 ↓
┌─────────────────────────────────────────┐
│ Controllers (app/Http/Controllers)      │
└────────────────┬────────────────────────┘
                 ↓
┌─────────────────────────────────────────┐
│ Services (app/Services)                 │
│ - OrderService (BOM & logika pesanan)   │
│ - StockService (manajemen stok)         │
└────────────────┬────────────────────────┘
                 ↓
┌─────────────────────────────────────────┐
│ Models & Database Layer (Eloquent)      │
└─────────────────────────────────────────┘
```

### File Structure

```
app/
├── Enums/                          # Type-safe enumerations
│   ├── OrderStatus.php             # pending, completed, cancelled
│   └── StockLogType.php            # in, out, adjustment
├── Exceptions/                     # Custom exception classes
│   ├── InsufficientStockException.php
│   └── MaterialNotFoundException.php
├── Http/
│   ├── Controllers/                # Request handling
│   │   ├── OrderController.php
│   │   ├── MaterialController.php
│   │   ├── ProductController.php
│   │   └── ReportController.php
│   ├── Requests/                   # Form validation
│   │   ├── StoreOrderRequest.php
│   │   ├── StoreStockRequest.php
│   │   └── ReduceStockRequest.php
│   └── Resources/                  # API response transformers
│       ├── OrderResource.php
│       ├── MaterialResource.php
│       └── ProductResource.php
├── Models/                         # Eloquent ORM models
│   ├── Material.php
│   ├── MaterialPriceLog.php
│   ├── Product.php
│   ├── Order.php
│   ├── OrderItem.php
│   ├── StockLog.php
│   └── User.php
└── Services/                       # Business logic
    ├── OrderService.php
    └── StockService.php
```

### 12. Perancangan Antarmuka

**Halaman Utama:**

1. **Login Page** (`/login`)
    - Username & password authentication
    - Session-based auth dengan remember me option

2. **Dashboard** (`/`)
    - Overview stok menipis
    - Statistik penjualan hari ini
    - Quick actions

3. **Kasir (POS)** (`/kasir`)
    - Select products & quantity
    - Real-time calculation total price
    - Submit order dengan validasi stok

4. **Gudang (Inventory)** (`/gudang`)
    - Table material dengan inline edit harga
    - Stock logs & price history
    - Restock functionality

5. **Laporan** (`/laporan`)
    - List orders dengan filter tanggal
    - Export ke PDF/Excel
    - Analisis profit

**Design Principles:**

- **Responsive Design**: Mobile-first approach dengan Tailwind breakpoints
- **Accessibility**: Semantic HTML, keyboard navigation, ARIA labels
- **UX Best Practices**: Loading states, error messages, confirmation dialogs

---

## IV. IMPLEMENTASI

### 13. Alur Bisnis Proses

**Alur Pembuatan Pesanan (Order Processing Flow):**

```
┌─────────────────────────────────────────────────────────────┐
│ 1. CLIENT REQUEST                                           │
│    POST /api/buat-pesanan                                   │
│    {                                                        │
│      "customer_name": "Ibu Sarah",                          │
│      "items": [                                             │
│        {"product_id": 1, "quantity": 2},                    │
│        {"product_id": 5, "quantity": 3}                     │
│      ]                                                      │
│    }                                                        │
└────────────────────┬────────────────────────────────────────┘
                     ↓
┌─────────────────────────────────────────────────────────────┐
│ 2. VALIDATION LAYER (StoreOrderRequest)                     │
│    ✓ customer_name: required, string, max:255              │
│    ✓ items: required, array, min:1                         │
│    ✓ items.*.product_id: exists in products table          │
│    ✓ items.*.quantity: required, integer, min:1            │
└────────────────────┬────────────────────────────────────────┘
                     ↓
┌─────────────────────────────────────────────────────────────┐
│ 3. CONTROLLER (OrderController::store)                      │
│    - Call OrderService::createOrder($validatedData)         │
│    - Wrap in try-catch for exception handling               │
└────────────────────┬────────────────────────────────────────┘
                     ↓
┌─────────────────────────────────────────────────────────────┐
│ 4. SERVICE LAYER (OrderService::createOrder)                │
│    ┌────────────────────────────────────────────────────┐   │
│    │ 4.1 Calculate Total Needs from BOM                 │   │
│    │     For each item:                                 │   │
│    │       - Get product with materials (BOM)           │   │
│    │       - Calculate: qty_needed × order_quantity     │   │
│    │     Aggregate total needs per material             │   │
│    └────────────────┬───────────────────────────────────┘   │
│                     ↓                                        │
│    ┌────────────────────────────────────────────────────┐   │
│    │ 4.2 Validate Stock Availability                    │   │
│    │     For each material:                             │   │
│    │       - Check: current_stock >= total_needs        │   │
│    │       - If insufficient: throw exception           │   │
│    │       - Else: continue                             │   │
│    └────────────────┬───────────────────────────────────┘   │
│                     ↓                                        │
│    ┌────────────────────────────────────────────────────┐   │
│    │ 4.3 DB Transaction Begin                           │   │
│    │     DB::transaction(function() {                   │   │
│    │       - Create Order record                        │   │
│    │       - Create OrderItem records                   │   │
│    │       - Decrement material stocks                  │   │
│    │       - Create StockLog entries                    │   │
│    │       - Return created Order                       │   │
│    │     });                                            │   │
│    └────────────────┬───────────────────────────────────┘   │
└────────────────────────────────────────────────────────────┘
                     ↓
┌─────────────────────────────────────────────────────────────┐
│ 5. RESPONSE FORMATTING (OrderResource)                      │
│    {                                                        │
│      "status": "success",                                   │
│      "message": "Order processed successfully",             │
│      "data": {                                              │
│        "id": 15,                                            │
│        "customer_name": "Ibu Sarah",                        │
│        "total_price": 250000,                               │
│        "total_hpp": 120000,                                 │
│        "profit": 130000,                                    │
│        "items": [...]                                       │
│      }                                                      │
│    }                                                        │
└─────────────────────────────────────────────────────────────┘
```

**Transaction Safety:**

Penggunaan **Database Transaction** memastikan ACID properties:

- **Atomicity**: Semua operasi sukses atau semua rollback
- **Consistency**: Database selalu dalam state valid
- **Isolation**: Transaksi bersamaan tidak saling ganggu
- **Durability**: Perubahan permanen setelah commit

**Contoh Perhitungan BOM:**

```
Order: 2× Kue Tart Bolu 14

BOM Kue Tart Bolu 14:               Perhitungan Kebutuhan:
- Tepung Terigu: 120g               120g × 2 = 240g
- Telur: 2 butir                    2 × 2 = 4 butir
- Gula Pasir: 90g                   90g × 2 = 180g
- Mentega: 80g                      80g × 2 = 160g
- Susu Cair: 50ml                   50ml × 2 = 100ml

Validasi Stok:
✓ Tepung Terigu (stok: 500g) >= 240g → OK
✓ Telur (stok: 10 butir) >= 4 butir → OK
✓ Gula Pasir (stok: 300g) >= 180g → OK
✓ Mentega (stok: 1000g) >= 160g → OK
✓ Susu Cair (stok: 200ml) >= 100ml → OK

Hasil: Order diterima, stok dikurangi, log tercatat
```

### 14. API Endpoints

**RESTful API Endpoints:**

### 14. API Endpoints

**RESTful API Endpoints:**

#### Authentication (Web Routes)

| Method | Endpoint    | Deskripsi    | Request Body           | Response           |
| ------ | ----------- | ------------ | ---------------------- | ------------------ |
| POST   | `/login`    | Login user   | `username`, `password` | Redirect + session |
| POST   | `/logout`   | Logout user  | -                      | Redirect           |
| GET    | `/api/user` | User profile | -                      | User JSON          |

#### Products & Materials

| Method | Endpoint                          | Deskripsi                    | Auth     |
| ------ | --------------------------------- | ---------------------------- | -------- |
| GET    | `/api/products`                   | List produk dengan BOM       | Optional |
| GET    | `/api/materials`                  | List material dengan stok    | Optional |
| PATCH  | `/api/materials/{material}/price` | Update harga per satuan baku | Required |
| GET    | `/api/materials/price-history`    | Riwayat perubahan harga      | Optional |

#### Orders (Point of Sale)

| Method | Endpoint            | Deskripsi         | Request Body             | Response    |
| ------ | ------------------- | ----------------- | ------------------------ | ----------- |
| POST   | `/api/buat-pesanan` | Buat pesanan baru | `customer_name`, `items` | Order + 201 |
| GET    | `/api/reports`      | Laporan penjualan | -                        | Order list  |

#### Stock Management

| Method | Endpoint                | Deskripsi                 | Request Body                    | Response    |
| ------ | ----------------------- | ------------------------- | ------------------------------- | ----------- |
| POST   | `/api/stocks/add`       | Tambah stok material      | `material_id`, `amount`, `desc` | Success msg |
| POST   | `/api/materials/reduce` | Kurangi stok (adjustment) | `material_id`, `amount`, `desc` | Success msg |
| GET    | `/api/stocks/history`   | Riwayat log stok          | `?material_id=X` (optional)     | Log list    |

**Request Example:**

```http
POST /api/buat-pesanan
Content-Type: application/json

{
    "customer_name": "Ibu Sarah",
    "items": [
        { "product_id": 1, "quantity": 2 },
        { "product_id": 5, "quantity": 3 }
    ]
}
```

**Response Examples:**

```json
// Success (201 Created)
{
    "status": "success",
    "message": "Order processed successfully.",
    "data": {
        "id": 15,
        "customer_name": "Ibu Sarah",
        "order_date": "2026-02-12T10:30:00.000000Z",
        "status": "completed",
        "total_price": 250000,
        "total_hpp": 120000,
        "profit": 130000,
        "items": [
            {
                "product_id": 1,
                "product_name": "Kue Tart Bolu 14",
                "quantity": 2,
                "price_per_unit": 70000,
                "subtotal": 140000
            }
        ]
    }
}

// Error - Insufficient Stock (400 Bad Request)
{
    "status": "error",
    "message": "Stok Tepung Terigu tidak cukup. Dibutuhkan: 540g, Tersedia: 400g"
}

// Error - Validation Failed (422 Unprocessable Entity)
{
    "message": "The customer name field is required.",
    "errors": {
        "customer_name": ["The customer name field is required."],
        "items": ["The items field must have at least 1 items."]
    }
}
```

### 15. Validasi & Error Handling

| Method | Endpoint    | Deskripsi             |
| ------ | ----------- | --------------------- |
| POST   | `/login`    | Login user            |
| POST   | `/logout`   | Logout user           |
| GET    | `/api/user` | Profil user (Sanctum) |

### Products & Materials

| Method | Endpoint                          | Deskripsi                    |
| ------ | --------------------------------- | ---------------------------- |
| GET    | `/api/products`                   | List produk dengan BOM       |
| GET    | `/api/materials`                  | List material dengan stok    |
| PATCH  | `/api/materials/{material}/price` | Update harga per satuan baku |
| GET    | `/api/materials/price-history`    | Riwayat perubahan harga      |

### Orders

| Method | Endpoint            | Auth  |
| ------ | ------------------- | ----- |
| POST   | `/api/buat-pesanan` | Tidak |
| GET    | `/api/reports`      | Tidak |

### Manajemen Stok

| Method | Endpoint                | Auth  |
| ------ | ----------------------- | ----- |
| POST   | `/api/stocks/add`       | Tidak |
| POST   | `/api/materials/reduce` | Tidak |
| GET    | `/api/stocks/history`   | Tidak |

**Catatan**: Endpoint API saat ini belum diproteksi autentikasi, kecuali `/api/user` (Sanctum). Tambahkan middleware `auth:sanctum` jika diperlukan.

### Request Example

POST /api/buat-pesanan

```json
{
    "customer_name": "Ibu Sarah",
    "items": [
        { "product_id": 1, "quantity": 2 },
        { "product_id": 5, "quantity": 3 }
    ]
}
```

### Response Format

**Success (201)**

```json
{
    "status": "success",
    "message": "Order berhasil dibuat",
    "data": {
        "id": 15,
        "customer_name": "Ibu Sarah",
        "total_price": 250000,
        "total_hpp": 120000,
        "profit": 130000
    }
}
```

**Error (400)**

```json
{
    "status": "error",
    "message": "Stok Tepung tidak cukup (dibutuhkan 540g, hanya 400g)"
}
```

---

## Validasi & Error Handling

### FormRequest Validation

**StoreOrderRequest**

- `customer_name`: required, string, max:255
- `items`: required, array, min:1
- `items.*.product_id`: required, integer, exists:products,id
- `items.*.quantity`: required, integer, min:1

**StoreStockRequest & ReduceStockRequest**

- `material_id`: required, integer, exists:materials,id
- `amount`: required, integer, min:1
- `description`: required, string, max:255

### Custom Exceptions

- **InsufficientStockException** - Stok tidak cukup
- **MaterialNotFoundException** - Material tidak ditemukan

### HTTP Response Codes

| Code | Scenario                          |
| ---- | --------------------------------- |
| 400  | Validasi gagal / stok tidak cukup |
| 404  | Resource not found                |
| 401  | Unauthenticated                   |
| 500  | Server error                      |

---

## Setup & Installation

### Prerequisites

- PHP 8.2+
- Composer 2+
- Node.js LTS
- MySQL Server 8.x (atau MariaDB yang kompatibel)

### Installation Steps

```bash
# 1. Clone repository
git clone https://github.com/yuhdaq-noob/nisa-cake-laravel.git
cd nisa-app

# 2. Install dependencies
composer install
npm install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Database (MySQL) & seeding
# Buat database bernama `nisa_app` (mis. lewat DataGrip), lalu set `.env`:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=nisa_app
# DB_USERNAME=root
# DB_PASSWORD=

php artisan migrate --seed

# 5. Build assets
npm run build

# 6. Start server
php artisan serve
```

Akses aplikasi di `http://localhost:8000` dengan:

- Username: `owner`
- Password: `666666`

---

## Testing

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test tests/Feature/Http/Controllers/OrderControllerTest.php

# Test coverage
php artisan test --coverage
```

Test cases mencakup:

- ✅ Pembuatan pesanan & validasi
- ✅ Perhitungan BOM
- ✅ Logika pengurangan stok
- ✅ Penanganan exception
- ✅ Pencatatan stok
- ✅ API endpoints
- ✅ Concurrent requests

---

## Deployment

### Production Checklist

```bash
# Optimize & cache
composer install --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Database
php artisan migrate --force
php artisan db:seed --force

# Build frontend
npm ci --omit=dev
npm run build

# Set permissions (Linux)
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Environment Variables

```
APP_ENV=production
APP_DEBUG=false
DB_CONNECTION=mysql
DB_HOST=your-host
DB_DATABASE=nisa_app
DB_USERNAME=user
DB_PASSWORD=password
```

### Webserver Configuration (Nginx)

```nginx
server {
    listen 80;
    server_name nisa-app.example.com;
    root /var/www/nisa-app/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

---

### 21. FAQ & Troubleshooting

**Q: Cara menambah produk/material baru?**

A: Via `php artisan tinker`:

```php
Material::create([
    'name' => 'Mentega',
    'unit' => 'g',
    'unit_baku' => 'kg',
    'price_per_unit' => 25,
    'price_per_unit_baku' => 25000,
    'current_stock' => 10000,
    'min_stock_level' => 1000
]);
```

**Q: Bagaimana pelacakan stok bekerja?**

A: Setiap perubahan dicatat di `stock_logs` dengan kolom: `material_id`, `type` (in/out/adjustment), `amount`, `description`, dan `timestamp`.

**Q: Bagaimana transaction safety mencegah race condition?**

A: Laravel DB transactions memastikan:

- Semua operasi dalam transaction bersifat atomic
- Jika terjadi error, semua perubahan di-rollback
- Perubahan stok dan pembuatan order dilakukan dalam satu unit kerja yang konsisten

**Q: Apakah bisa menggunakan SQLite untuk demo/quick start?**

A: Bisa. Jika ingin tanpa setup server database, ubah `.env`:

```
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database.sqlite
```

Lalu jalankan: `php artisan migrate:fresh --seed`

**Q: Cara backup database production?**

A:

```bash
# MySQL
mysqldump -u root -p nisa_app > backups/db_$(date +%Y%m%d).sql

# Alternatif (GUI): export/backup via DataGrip
```

---

### 22. Referensi

**Referensi Kode Penting:**

| File                                            | Fungsi                                |
| ----------------------------------------------- | ------------------------------------- |
| `app/Services/OrderService.php`                 | Business logic pemrosesan pesanan BOM |
| `app/Services/StockService.php`                 | Stock management & logging            |
| `app/Models/Product.php`                        | Model produk dengan BOM relationships |
| `app/Exceptions/InsufficientStockException.php` | Custom exception stok tidak cukup     |
| `routes/api.php`                                | RESTful API endpoint definitions      |
| `database/migrations/`                          | Database schema & migrations          |

**Dokumentasi Terkait:**

- [README.md](README.md) - Quick start guide & overview
- [CHANGELOG.md](CHANGELOG.md) - Version history & release notes
- [LICENSE](LICENSE) - MIT License information

**Tech Stack Documentation:**

- [Laravel 12 Documentation](https://laravel.com/docs/12.x)
- [PHP 8.2 Release Notes](https://www.php.net/releases/8.2/)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [Vite Documentation](https://vitejs.dev/)

**Best Practices Reference:**

- Clean Architecture Principles (Robert C. Martin)
- Laravel Best Practices & Design Patterns
- RESTful API Design Guidelines
- Database Transaction Management

---

### Informasi Penulis

| Atribut           | Keterangan                               |
| ----------------- | ---------------------------------------- |
| Nama Aplikasi     | NISA-APP (Nisa Cake Management System)   |
| Versi Dokumentasi | 1.0.0                                    |
| Tanggal Update    | 12 Februari 2026                         |
| Framework         | Laravel 12.x (PHP 8.2+)                  |
| Lisensi           | MIT License                              |
| Repository        | [GitHub Repository Link (To be updated)] |

---

**© 2026 NISA-APP — Sistem Manajemen Toko Kue Berbasis BOM**

_Dokumentasi ini dibuat untuk keperluan Tugas Akhir/Skripsi. Untuk pertanyaan atau kontribusi, silakan buat issue di repository GitHub._

---

## VI. PENUTUP

### 20. Kesimpulan

Penelitian ini berhasil merancang dan mengimplementasikan sistem manajemen inventori berbasis Bill of Materials (BOM) untuk toko kue dengan fitur-fitur utama sebagai berikut:

**Pencapaian Tujuan:**

1. ✅ **Otomasi Perhitungan BOM**: Sistem dapat menghitung kebutuhan bahan baku secara otomatis berdasarkan resep produk (BOM), mengeliminasi kesalahan perhitungan manual.

2. ✅ **Transaction Safety**: Implementasi database transactions memastikan konsistensi data dengan ACID properties, mencegah race condition dan data corruption.

3. ✅ **Audit Trail Lengkap**: Setiap perubahan stok dan harga tercatat di `stock_logs` dan `material_price_logs` untuk transparansi dan akuntabilitas.

4. ✅ **Laporan Akurat**: Sistem menghasilkan laporan penjualan dengan kalkulasi HPP (Harga Pokok Produksi) dan profit yang akurat untuk pengambilan keputusan bisnis.

5. ✅ **Clean Architecture**: Penerapan layered architecture (Controller → Service → Model) meningkatkan maintainability, testability, dan scalability.

**Kontribusi Penelitian:**

- **Praktis**: Meningkatkan efisiensi operasional melalui otomasi perhitungan BOM, validasi stok, dan pencatatan transaksi
- **Akademis**: Menyediakan studi kasus implementasi BOM system dengan modern tech stack (Laravel 12, PHP 8.2+)
- **Teknis**: Demonstrasi best practices pengembangan software (type safety, dependency injection, error handling)

**Keterbatasan Sistem:**

- Sistem saat ini monolitik, belum support multi-tenancy untuk multiple cabang
- Belum terintegrasi dengan hardware POS (barcode scanner, thermal printer)
- Deployment masih manual, belum CI/CD pipeline

**Rekomendasi Pengembangan Lanjutan:**

1. **Microservices Architecture**: Pisahkan inventory service, order service untuk scalability
2. **Mobile App**: Buat aplikasi mobile untuk pemilik toko (monitoring real-time)
3. **Advanced Analytics**: Implementasi forecasting demand menggunakan machine learning
4. **Payment Gateway**: Integrasi dengan Midtrans/Xendit untuk cashless payment
5. **Multi-Branch Support**: Extend database schema untuk support multiple locations

### 21. FAQ & Troubleshooting
