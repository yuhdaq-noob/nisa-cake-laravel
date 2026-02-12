<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// PENTING: Tambahkan ini untuk enkripsi password

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Matikan pengecekan Foreign Key agar bisa reset tabel
        Schema::disableForeignKeyConstraints();

        // 2. Kosongkan SEMUA tabel (Reset bersih)
        DB::table('order_items')->truncate();
        DB::table('orders')->truncate();
        DB::table('product_materials')->truncate();
        DB::table('products')->truncate();
        DB::table('materials')->truncate();
        DB::table('users')->truncate(); // Reset user juga biar tidak duplikat

        // 3. Nyalakan lagi Foreign Key
        Schema::enableForeignKeyConstraints();

        // ==========================================
        // 0. DATA USER (OWNER) - PENTING!
        // Gunakan `OwnerSeeder` untuk membuat akun owner
        // ==========================================
        $this->call([
            OwnerSeeder::class, // Cek & buat user owner jika belum ada
        ]);

        // Pindahkan seed master-data (materials, products, product_materials)
        // ke `MasterDataSeeder` untuk menjaga konsistensi dan
        // menghindari duplikasi. MasterDataSeeder dibuat di file terpisah.
        $this->call([
            MasterDataSeeder::class,
            OrderSeeder::class,
            StockSeeder::class,  // Uncomment jiika ingin generate dummy orders
        ]);
    }
}
