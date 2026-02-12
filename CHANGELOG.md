# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.0.0] - 2026-02-11

### Added

- Initial release of NISA-APP
- Point of Sale (POS) system untuk kasir
- Manajemen inventori dengan Bill of Materials (BOM)
- Pengurangan stok otomatis saat order dibuat
- Pencatatan stok untuk audit trail
- Peringatan stok minimum (min_stock_level)
- Laporan penjualan dengan perhitungan profit
- User authentication system
- 21 produk kue dengan BOM lengkap
- 18 bahan baku (materials)
- API endpoints untuk integrasi mobile/eksternal
- Responsive UI dengan Tailwind CSS

### Features

- **BOM System**: Automatic material calculation per product
- **Transaction Safety**: Database transactions untuk data consistency
- **Type Safety**: Full PHP 8.2 type hints & property casts
- **Service Layer**: Clean architecture dengan separation of concerns
- **Custom Exceptions**: `InsufficientStockException`, `MaterialNotFoundException`
- **API Resources**: Consistent JSON response format
- **Form Validation**: Centralized validation dengan FormRequests
- **Enums**: `OrderStatus`, `StockLogType` untuk type-safe status handling

### Technical Stack

- Laravel 12.x
- PHP 8.2+
- MySQL Database (default)
- Vite 7.x
- Tailwind CSS 4.0
- Laravel Sanctum 4.0

### Database Schema

- `materials` - Bahan baku
- `products` - Produk jadi
- `product_materials` - BOM (pivot table)
- `orders` - Transaksi penjualan
- `order_items` - Detail order
- `stock_logs` - Riwayat stok
- `users` - User authentication

### Controllers

- `OrderController` - Order management
- `ProductController` - Product listing
- `MaterialController` - Material & stock management
- `StockController` - Stock addition & history
- `ReportController` - Sales reports
- `InventoryController` - Inventory page
- `LoginController` - Authentication

### Services

- `OrderService` - Order processing logic & BOM calculation
- `StockService` - Stock addition & reduction with logging

### Security

- CSRF Protection
- Session-based authentication
- Password hashing (bcrypt)
- SQL injection prevention (Eloquent ORM)
- XSS protection (Blade escaping)
- Form request validation

### Documentation

- Complete README.md with setup instructions
- Technical document (DOKUMENTASI_TEKNIS.md) in Bahasa Indonesia
- Publication checklist (READY_FOR_PUBLICATION.md)
- MIT License

### Changed

- Added type hints to all models & controllers
- Standardized API response format
- Improved error handling with logging
- Added property casts for type safety
- Moved business logic from routes to controllers
- Consistent indentation & formatting

### Fixed

- Fixed typo `Use` → `use` in Material.php
- Added missing `username` field to User fillable
- Fixed inconsistent route naming
- Fixed response format inconsistencies
- Fixed code indentation issues

---

[Unreleased]: https://github.com/yourusername/nisa-app/compare/v1.0.0...HEAD
[1.0.0]: https://github.com/yourusername/nisa-app/releases/tag/v1.0.0
