# NISA-APP

**Sistem Manajemen Toko Kue dengan Inventori & BOM (Bill of Materials)**

[![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

---

## Tentang Proyek

**NISA-APP** adalah aplikasi web untuk mengelola toko kue (Nisa Cake) yang mencakup:

- Point of Sale (POS) untuk kasir
- Manajemen inventori berbasis Bill of Materials (BOM)
- Laporan penjualan dengan informasi omzet, HPP, dan laba
- Notifikasi stok minimum saat persediaan menipis
- Pencatatan perubahan stok (audit trail)
- Pencatatan perubahan harga bahan baku

### Fitur Utama

- Bill of Materials (BOM) untuk perhitungan kebutuhan bahan per produk
- Pengurangan stok otomatis saat pesanan dibuat (auto stock deduction)
- Transaction safety dengan database transaction untuk menjaga konsistensi data
- Custom exceptions untuk error handling yang informatif
- API Resources untuk response format yang konsisten
- Service layer untuk memisahkan business logic dan meningkatkan maintainability

---

## Tech Stack

### Backend

- **Laravel** 12.x (PHP Framework)
- **PHP** 8.2+ (Programming Language)
- **MySQL** 8.x (Database)
- _(Opsional)_ **SQLite** untuk demo/quick start
- **Laravel Sanctum** 4.0 (API Authentication)

### Frontend

- **Vite** 7.x (Build Tool)
- **Tailwind CSS** 4.0 (Styling)
- **Axios** 1.11 (HTTP Client)
- **Vanilla JavaScript** (Interactivity, custom UI helpers)

### Development Tools

- **PHPUnit** 11.5 (Testing)
- **Laravel Pint** 1.24 (Code Style)
- **Laravel Pail** 1.2 (Log Viewer)
- **Composer** 2+ (Dependency Manager)
- **Node.js** LTS (JavaScript Runtime)
- _(Opsional)_ **DataGrip** / **phpMyAdmin** untuk manajemen database
- _(Opsional)_ **PhpStorm** / **VS Code** sebagai IDE

---

## Instalasi

### Requirements

- PHP >= 8.2
- Composer >= 2.0
- Node.js >= 18.x (LTS)
- MySQL Server >= 8.0 (atau MariaDB yang kompatibel)

### Langkah Instalasi

1. **Clone Repository**

    ```bash
    git clone https://github.com/yuhdaq-noob/nisa-cake-laravel.git
    cd nisa-app
    ```

2. **Install Dependencies**

    ```bash
    composer install
    npm install
    ```

3. **Environment Setup**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Database Setup**

    **Buat database MySQL**, misalnya dengan DataGrip:
    - Database name: `nisa_app`

    Lalu konfigurasi `.env`:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nisa_app
    DB_USERNAME=root
    DB_PASSWORD=
    ```

    Jalankan migrasi + seeding:

    ```bash
    php artisan migrate --seed
    ```

    Seeder akan membuat:
    - User owner (username: `owner`, password: `666666`)
    - 18 bahan baku (materials)
    - 21 produk kue dengan BOM
    - Sample order dan log stok

5. **Build Assets**

    ```bash
    npm run build
    # atau untuk development:
    npm run dev
    ```

6. **Run Server**

    ```bash
    php artisan serve
    ```

    Aplikasi akan berjalan di `http://localhost:8000`

---

## Default Login

```
Username: owner
Password: 666666
```

---

## Project Structure

```
nisa-app/
├── app/
│   ├── Enums/              # OrderStatus, StockLogType
│   ├── Exceptions/         # Custom exceptions
│   ├── Http/
│   │   ├── Controllers/    # API & Web controllers
│   │   ├── Requests/       # Form validations
│   │   └── Resources/      # API response transformers
│   ├── Models/             # Eloquent models
│   └── Services/           # Business logic layer
├── database/
│   ├── migrations/         # Database schema
│   └── seeders/            # Data seeders
├── resources/
│   ├── css/
│   │   ├── app.css         # Tailwind base + global theme (layout, kartu, tabel)
│   │   ├── login-tailwind.css # Styling khusus halaman login
│   │   └── legacy/         # Stylesheet lama (gudang/kasir/laporan/login sebelum migrasi Tailwind)
│   ├── js/
│   │   ├── app.js          # Entry Vite, menginisialisasi UI layer & modul halaman
│   │   ├── ui.js           # Helper interaksi UI (drawer, modal, dropdown)
│   │   ├── utils.js        # Helper umum (format Rupiah, tanggal, error state)
│   │   ├── gudang.js       # Logika halaman gudang (stok & harga)
│   │   ├── kasir.js        # Logika halaman kasir (POS)
│   │   └── laporan.js      # Logika halaman laporan keuangan (tabel + chart)
│   └── views/              # Blade templates (layouts, components, pages)
└──  routes/
    ├── api.php             # API routes
    └── web.php             # Web routes

```

---

## Dokumentasi

### Changelog

Lihat **[CHANGELOG.md](CHANGELOG.md)** untuk detail riwayat versi dan perubahan.

---

## Testing

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=OrderServiceTest
```

---

## Development

### Menjalankan Development Server

```bash
# Terminal 1: PHP Server
php artisan serve

# Terminal 2: Vite Dev Server (hot reload)
npm run dev
```

### Code Style

```bash
# Fix code style
./vendor/bin/pint
```

### Clear Cache

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

---

## Database Schema

### Main Tables

- **materials** - Bahan baku (harga per unit & per satuan baku)
- **material_price_logs** - Riwayat perubahan harga bahan
- **products** - Produk jadi (kue tart, brownies, dll)
- **product_materials** - BOM (resep produk)
- **orders** - Transaksi penjualan
- **order_items** - Detail item per pesanan
- **stock_logs** - Riwayat perubahan stok
- **users** - User authentication

### Key Relationships

```
Product → Product_Materials → Materials (BOM)
Order → Order_Items → Products
Material → Stock_Logs
Material → Material_Price_Logs
```

---

## API Endpoints

### Authentication (API)

- Public: `POST /api/login` (login), `POST /api/register` (register user baru)
- Protected: `POST /api/logout`, `GET /api/user` (profil user)

### Products & Materials (auth:sanctum)

- `GET /api/products` - List produk dengan BOM
- `GET /api/materials` - List material dengan stok
- `PATCH /api/materials/{material}/price` - Update harga per satuan baku
- `GET /api/materials/price-history` - Riwayat perubahan harga

### Orders (auth:sanctum)

- `POST /api/buat-pesanan` - Buat pesanan (auto stock deduction)
- `GET /api/orders` - List pesanan
- `GET /api/orders/{order}` - Detail pesanan
- `PATCH /api/orders/{order}/complete` - Tandai selesai
- `GET /api/reports` - List pesanan dengan profit

### Manajemen Stok (auth:sanctum)

- `POST /api/stocks/add` - Tambah stok material
- `POST /api/materials/reduce` - Kurangi stok (manual adjustment)
- `GET /api/stocks/history` - Riwayat log stok

**Catatan**: Kecuali `POST /api/login` dan `POST /api/register`, seluruh endpoint API di atas sudah diproteksi middleware `auth:sanctum` (Bearer Token dari Sanctum).

---

## Business Logic

### Alur Pesanan

1. Client mengirim pesanan dengan daftar produk & quantity
2. Sistem menghitung kebutuhan material dari BOM
3. Validasi ketersediaan stok
4. Jika cukup: buat pesanan + kurangi stok (dalam transaction)
5. Jika kurang: lempar `InsufficientStockException`
6. Log semua perubahan stok ke `stock_logs`

### Contoh Perhitungan Stok

```
Order: 2x Kue Tart Bolu 14

BOM Kue Tart Bolu 14:
- Tepung: 120g
- Telur: 2 butir
- Gula: 90g
(dst...)

Total Kebutuhan:
- Tepung: 120g × 2 = 240g
- Telur: 2 × 2 = 4 butir
- Gula: 90g × 2 = 180g
```

---

## Security Features

- CSRF protection
- Session-based authentication
- Password hashing (bcrypt)
- SQL injection prevention (Eloquent ORM)
- XSS protection (Blade escaping)
- Form Request validation

---

## Performance

- Database indexing on foreign keys
- Eager loading untuk prevent N+1 queries
- Config & route caching untuk production
- Asset bundling dengan Vite

---

## Contributing

Kontribusi sangat diterima! Jika Anda ingin berkontribusi:

1. Fork repository ini
2. Buat branch baru (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan Anda (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

**Sebelum berkontribusi:**

- Pastikan kode mengikuti Laravel coding standards (gunakan `./vendor/bin/pint`)
- Tambahkan tests untuk fitur baru
- Update dokumentasi jika diperlukan

---

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

## Author

Developed as part of undergraduate thesis (Tugas Akhir/Skripsi).

**Tech Stack:**

- **Backend**: Laravel 12.x, PHP 8.2+
- **Frontend**: Vite 7.x, Tailwind CSS 4.0
- **Database**: MySQL 8.x

---

## Acknowledgments

- [Laravel](https://laravel.com) - The PHP framework for web artisans
- [Tailwind CSS](https://tailwindcss.com) - A utility-first CSS framework
- [Vite](https://vitejs.dev) - Next generation frontend tooling
- All open-source contributors who made this project possible

---

## Support

Jika Anda menemukan bug atau memiliki pertanyaan:

- **Issues**: [GitHub Issues](https://github.com/yuhdaq-noob/nisa-cake-laravel/issues)
- **Documentation**: [DOKUMENTASI_TEKNIS.md](DOKUMENTASI_TEKNIS.md)
- **Email**: _yuhdaq@gmail.com_

---

**Built with ❤️ for Nisa Cake Management System**
