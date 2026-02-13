<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        // Isi data master: materials, products, product_materials
        DB::table('materials')->insert([    // TODO: ADA BAHAN YANG BELUM DI PERBAIKI HARGA / STOK MINIMUM NYA
            // Format: ['id', 'name', 'unit', 'unit_baku', 'price_per_unit', 'price_per_unit_baku', 'current_stock', 'min_stock_level']
            ['id' => 1, 'name' => 'Tepung Terigu', 'unit' => 'gram', 'unit_baku' => 'gram', 'price_per_unit' => 12.0, 'price_per_unit_baku' => 12.0, 'current_stock' => 0, 'min_stock_level' => 5000, 'created_at' => now(), 'updated_at' => now()], // min 5 kg
            ['id' => 2, 'name' => 'Telur Ayam', 'unit' => 'butir', 'unit_baku' => 'butir', 'price_per_unit' => 1750.0, 'price_per_unit_baku' => 1750.0, 'current_stock' => 0, 'min_stock_level' => 60, 'created_at' => now(), 'updated_at' => now()], // min 2 tray
            ['id' => 3, 'name' => 'SP (Emulsifier)', 'unit' => 'gram', 'unit_baku' => 'gram', 'price_per_unit' => 150.0, 'price_per_unit_baku' => 150.0, 'current_stock' => 0, 'min_stock_level' => 200, 'created_at' => now(), 'updated_at' => now()], // min 200 gr
            ['id' => 4, 'name' => 'Minyak Goreng', 'unit' => 'gram', 'unit_baku' => 'gram', 'price_per_unit' => 19.0, 'price_per_unit_baku' => 19.0, 'current_stock' => 0, 'min_stock_level' => 2000, 'created_at' => now(), 'updated_at' => now()], // min 2 liter
            ['id' => 5, 'name' => 'Gula Pasir', 'unit' => 'gram', 'unit_baku' => 'gram', 'price_per_unit' => 17.5, 'price_per_unit_baku' => 17.5, 'current_stock' => 0, 'min_stock_level' => 5000, 'created_at' => now(), 'updated_at' => now()], // min 5 kg
            ['id' => 6, 'name' => 'Pewarna Pandan', 'unit' => 'gram', 'unit_baku' => 'gram', 'price_per_unit' => 133.0, 'price_per_unit_baku' => 133.0, 'current_stock' => 0, 'min_stock_level' => 100, 'created_at' => now(), 'updated_at' => now()], // min 100 gr
            ['id' => 7, 'name' => 'Coklat Bubuk', 'unit' => 'gram', 'unit_baku' => 'gram', 'price_per_unit' => 130.0, 'price_per_unit_baku' => 130.0, 'current_stock' => 0, 'min_stock_level' => 500, 'created_at' => now(), 'updated_at' => now()], // min 0.5 kg
            ['id' => 8, 'name' => 'Coklat Batang', 'unit' => 'gram', 'unit_baku' => 'gram', 'price_per_unit' => 85.0, 'price_per_unit_baku' => 85.0, 'current_stock' => 0, 'min_stock_level' => 1000, 'created_at' => now(), 'updated_at' => now()], // min 1 kg
            ['id' => 9, 'name' => 'Butter Cream', 'unit' => 'gram', 'unit_baku' => 'gram', 'price_per_unit' => 50.0, 'price_per_unit_baku' => 50.0, 'current_stock' => 0, 'min_stock_level' => 1000, 'created_at' => now(), 'updated_at' => now()], // min 1 kg
            ['id' => 10, 'name' => 'Mentega/Margarin', 'unit' => 'gram', 'unit_baku' => 'gram', 'price_per_unit' => 50.0, 'price_per_unit_baku' => 50.0, 'current_stock' => 0, 'min_stock_level' => 2000, 'created_at' => now(), 'updated_at' => now()], // min 2 kg
            ['id' => 11, 'name' => 'Tepung Maizena', 'unit' => 'gram', 'unit_baku' => 'gram', 'price_per_unit' => 25.0, 'price_per_unit_baku' => 25.0, 'current_stock' => 0, 'min_stock_level' => 500, 'created_at' => now(), 'updated_at' => now()], // min 0.5 kg
            ['id' => 12, 'name' => 'Susu Bubuk', 'unit' => 'gram', 'unit_baku' => 'gram', 'price_per_unit' => 60.0, 'price_per_unit_baku' => 60.0, 'current_stock' => 0, 'min_stock_level' => 500, 'created_at' => now(), 'updated_at' => now()], // min 0.5 kg
            ['id' => 13, 'name' => 'Selai', 'unit' => 'gram', 'unit_baku' => 'gram', 'price_per_unit' => 30.0, 'price_per_unit_baku' => 30.0, 'current_stock' => 0, 'min_stock_level' => 500, 'created_at' => now(), 'updated_at' => now()], // min 0.5 kg
            ['id' => 14, 'name' => 'Pisang', 'unit' => 'gram', 'unit_baku' => 'gram', 'price_per_unit' => 28.0, 'price_per_unit_baku' => 28.0, 'current_stock' => 0, 'min_stock_level' => 2000, 'created_at' => now(), 'updated_at' => now()], // min 2 kg
            ['id' => 15, 'name' => 'Santan Cair', 'unit' => 'gram', 'unit_baku' => 'gram', 'price_per_unit' => 35.0, 'price_per_unit_baku' => 35.0, 'current_stock' => 0, 'min_stock_level' => 1000, 'created_at' => now(), 'updated_at' => now()], // min 1 liter
            ['id' => 16, 'name' => 'Garam', 'unit' => 'gram', 'unit_baku' => 'gram', 'price_per_unit' => 10.0, 'price_per_unit_baku' => 10.0, 'current_stock' => 0, 'min_stock_level' => 250, 'created_at' => now(), 'updated_at' => now()], // min 1 bks kecil
            ['id' => 17, 'name' => 'Air Lemon', 'unit' => 'gram', 'unit_baku' => 'gram', 'price_per_unit' => 75.0, 'price_per_unit_baku' => 75.0, 'current_stock' => 0, 'min_stock_level' => 100, 'created_at' => now(), 'updated_at' => now()], // min 100 ml
            ['id' => 18, 'name' => 'Parutan Kelapa', 'unit' => 'gram', 'unit_baku' => 'gram', 'price_per_unit' => 38.0, 'price_per_unit_baku' => 38.0, 'current_stock' => 0, 'min_stock_level' => 1000, 'created_at' => now(), 'updated_at' => now()], // min 1 kg
        ]);

        // Setelah insert master materials, konversi ke unit baku (kg / liter)
        // price_per_unit: harga per unit kecil (gram / ml)
        // price_per_unit_baku: harga per unit baku (kg / liter / dll)
        DB::statement(
            "UPDATE materials\n".
            "SET\n".
            "  unit_baku = CASE\n".
            "    WHEN LOWER(unit) = 'gram' THEN 'kg'\n".
            "    WHEN LOWER(unit) = 'ml' THEN 'liter'\n".
            "    ELSE unit\n".
            "  END,\n".
            "  price_per_unit_baku = CASE\n".
            "    WHEN LOWER(unit) = 'gram' THEN price_per_unit * 1000\n".
            "    WHEN LOWER(unit) = 'ml' THEN price_per_unit * 1000\n".
            "    ELSE price_per_unit\n".
            "  END"
        );

        DB::table('products')->insert([
            ['id' => 1, 'name' => 'Kue Tart Bolu 14', 'selling_price' => 45000, 'production_cost' => 20721.0, 'description' => 'Kue Kue Tart Bolu 14', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Kue Tart Bolu 16', 'selling_price' => 50000, 'production_cost' => 29681.5, 'description' => 'Kue Kue Tart Bolu 16', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Kue Tart Bolu 18', 'selling_price' => 55000, 'production_cost' => 38792.0, 'description' => 'Kue Kue Tart Bolu 18', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Kue Tart Bolu 20', 'selling_price' => 60000, 'production_cost' => 47182.5, 'description' => 'Kue Kue Tart Bolu 20', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'Kue Tart Bolu 22', 'selling_price' => 65000, 'production_cost' => 56293.0, 'description' => 'Kue Tart Bolu 22', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name' => 'Kue Tart Bolu 24', 'selling_price' => 70000, 'production_cost' => 64683.5, 'description' => 'Kue Tart Bolu 24', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'name' => 'Kue Tart Brownies 14', 'selling_price' => 60000, 'production_cost' => 24483.5, 'description' => 'Kue Kue Tart Brownies 14', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'name' => 'Kue Tart Brownies 16', 'selling_price' => 75000, 'production_cost' => 34634.0, 'description' => 'Kue Kue Tart Brownies 16', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9, 'name' => 'Kue Tart Brownies 18', 'selling_price' => 100000, 'production_cost' => 46074.5, 'description' => 'Kue Tart Brownies 18', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 10, 'name' => 'Kue Tart Brownies 20', 'selling_price' => 120000, 'production_cost' => 56225.0, 'description' => 'Kue Tart Brownies 20', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 11, 'name' => 'Kue Tart Brownies 22', 'selling_price' => 135000, 'production_cost' => 67095.5, 'description' => 'Kue Tart Brownies 22', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 12, 'name' => 'Kue Tart Brownies 24', 'selling_price' => 160000, 'production_cost' => 77246.0, 'description' => 'Kue Tart Brownies 24', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 13, 'name' => 'Bolu Gulung (12 biji)', 'selling_price' => 35000, 'production_cost' => 23590.0, 'description' => 'Kue Bolu Gulung (12 biji)', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 14, 'name' => 'Bolu Pisang 18', 'selling_price' => 55000, 'production_cost' => 34710.0, 'description' => 'Kue Bolu Pisang 18', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 15, 'name' => 'Brownis Kukus 24 (30 biji)', 'selling_price' => 105000, 'production_cost' => 38815.0, 'description' => 'Kue Brownis Kukus 24 (30 biji)', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 16, 'name' => 'Brownis Panggang (15 biji)', 'selling_price' => 75000, 'production_cost' => 53495.0, 'description' => 'Kue Brownis Panggang (15 biji)', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 17, 'name' => 'Bolen pisang (40 biji)', 'selling_price' => 100000, 'production_cost' => 24385.0, 'description' => 'Kue Bolen pisang (40 biji)', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 18, 'name' => 'bolu jadul (24 biji)', 'selling_price' => 65000, 'production_cost' => 27183.5, 'description' => 'Kue bolu jadul (24 biji)', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 19, 'name' => 'Shifon cake (16 biji)', 'selling_price' => 56000, 'production_cost' => 20870.0, 'description' => 'Kue Shifon cake (16 biji)', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 20, 'name' => 'Bolu Kukus biasa (24 biji)', 'selling_price' => 60000, 'production_cost' => 32222.5, 'description' => 'Kue Bolu Kukus biasa (24 biji)', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 21, 'name' => 'Putu ayu (20 biji)', 'selling_price' => 60000, 'production_cost' => 58805.0, 'description' => 'Kue Putu ayu (20 biji)', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('product_materials')->insert([
            ['id' => 1, 'product_id' => 1, 'material_id' => 1, 'quantity_needed' => 120.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'product_id' => 1, 'material_id' => 2, 'quantity_needed' => 2.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'product_id' => 1, 'material_id' => 3, 'quantity_needed' => 2.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'product_id' => 1, 'material_id' => 4, 'quantity_needed' => 60.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'product_id' => 1, 'material_id' => 5, 'quantity_needed' => 90.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'product_id' => 1, 'material_id' => 6, 'quantity_needed' => 2.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'product_id' => 1, 'material_id' => 9, 'quantity_needed' => 250.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'product_id' => 2, 'material_id' => 1, 'quantity_needed' => 180.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9, 'product_id' => 2, 'material_id' => 2, 'quantity_needed' => 3.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 10, 'product_id' => 2, 'material_id' => 3, 'quantity_needed' => 2.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 11, 'product_id' => 2, 'material_id' => 4, 'quantity_needed' => 90.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 12, 'product_id' => 2, 'material_id' => 5, 'quantity_needed' => 135.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 13, 'product_id' => 2, 'material_id' => 6, 'quantity_needed' => 3.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 14, 'product_id' => 2, 'material_id' => 9, 'quantity_needed' => 350.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 15, 'product_id' => 3, 'material_id' => 1, 'quantity_needed' => 240.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 16, 'product_id' => 3, 'material_id' => 2, 'quantity_needed' => 4.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 17, 'product_id' => 3, 'material_id' => 3, 'quantity_needed' => 3.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 18, 'product_id' => 3, 'material_id' => 4, 'quantity_needed' => 120.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 19, 'product_id' => 3, 'material_id' => 5, 'quantity_needed' => 180.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 20, 'product_id' => 3, 'material_id' => 6, 'quantity_needed' => 4.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 21, 'product_id' => 3, 'material_id' => 9, 'quantity_needed' => 450.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 22, 'product_id' => 4, 'material_id' => 1, 'quantity_needed' => 300.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 23, 'product_id' => 4, 'material_id' => 2, 'quantity_needed' => 5.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 24, 'product_id' => 4, 'material_id' => 3, 'quantity_needed' => 3.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 25, 'product_id' => 4, 'material_id' => 4, 'quantity_needed' => 120.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 26, 'product_id' => 4, 'material_id' => 5, 'quantity_needed' => 225.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 27, 'product_id' => 4, 'material_id' => 6, 'quantity_needed' => 5.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 28, 'product_id' => 4, 'material_id' => 9, 'quantity_needed' => 550.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 29, 'product_id' => 5, 'material_id' => 1, 'quantity_needed' => 360.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 30, 'product_id' => 5, 'material_id' => 2, 'quantity_needed' => 6.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 31, 'product_id' => 5, 'material_id' => 3, 'quantity_needed' => 4.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 32, 'product_id' => 5, 'material_id' => 4, 'quantity_needed' => 150.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 33, 'product_id' => 5, 'material_id' => 5, 'quantity_needed' => 270.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 34, 'product_id' => 5, 'material_id' => 6, 'quantity_needed' => 6.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 35, 'product_id' => 5, 'material_id' => 9, 'quantity_needed' => 650.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 36, 'product_id' => 6, 'material_id' => 1, 'quantity_needed' => 420.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 37, 'product_id' => 6, 'material_id' => 2, 'quantity_needed' => 7.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 38, 'product_id' => 6, 'material_id' => 3, 'quantity_needed' => 4.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 39, 'product_id' => 6, 'material_id' => 4, 'quantity_needed' => 150.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 40, 'product_id' => 6, 'material_id' => 5, 'quantity_needed' => 315.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 41, 'product_id' => 6, 'material_id' => 6, 'quantity_needed' => 7.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 42, 'product_id' => 6, 'material_id' => 9, 'quantity_needed' => 750.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 43, 'product_id' => 7, 'material_id' => 1, 'quantity_needed' => 45.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 44, 'product_id' => 7, 'material_id' => 2, 'quantity_needed' => 2.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 45, 'product_id' => 7, 'material_id' => 3, 'quantity_needed' => 2.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 46, 'product_id' => 7, 'material_id' => 4, 'quantity_needed' => 60.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 47, 'product_id' => 7, 'material_id' => 5, 'quantity_needed' => 75.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 48, 'product_id' => 7, 'material_id' => 6, 'quantity_needed' => 2.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 49, 'product_id' => 7, 'material_id' => 7, 'quantity_needed' => 15.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 50, 'product_id' => 7, 'material_id' => 8, 'quantity_needed' => 35.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 51, 'product_id' => 7, 'material_id' => 9, 'quantity_needed' => 250.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 52, 'product_id' => 8, 'material_id' => 1, 'quantity_needed' => 70.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 53, 'product_id' => 8, 'material_id' => 2, 'quantity_needed' => 3.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 54, 'product_id' => 8, 'material_id' => 3, 'quantity_needed' => 2.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 55, 'product_id' => 8, 'material_id' => 4, 'quantity_needed' => 60.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 56, 'product_id' => 8, 'material_id' => 5, 'quantity_needed' => 110.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 57, 'product_id' => 8, 'material_id' => 6, 'quantity_needed' => 3.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 58, 'product_id' => 8, 'material_id' => 7, 'quantity_needed' => 22.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 59, 'product_id' => 8, 'material_id' => 8, 'quantity_needed' => 52.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 60, 'product_id' => 8, 'material_id' => 9, 'quantity_needed' => 350.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 61, 'product_id' => 9, 'material_id' => 1, 'quantity_needed' => 95.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 62, 'product_id' => 9, 'material_id' => 2, 'quantity_needed' => 4.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 63, 'product_id' => 9, 'material_id' => 3, 'quantity_needed' => 3.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 64, 'product_id' => 9, 'material_id' => 4, 'quantity_needed' => 120.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 65, 'product_id' => 9, 'material_id' => 5, 'quantity_needed' => 145.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 66, 'product_id' => 9, 'material_id' => 6, 'quantity_needed' => 4.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 67, 'product_id' => 9, 'material_id' => 7, 'quantity_needed' => 29.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 68, 'product_id' => 9, 'material_id' => 8, 'quantity_needed' => 69.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 69, 'product_id' => 9, 'material_id' => 9, 'quantity_needed' => 450.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 70, 'product_id' => 10, 'material_id' => 1, 'quantity_needed' => 120.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 71, 'product_id' => 10, 'material_id' => 2, 'quantity_needed' => 5.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 72, 'product_id' => 10, 'material_id' => 3, 'quantity_needed' => 3.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 73, 'product_id' => 10, 'material_id' => 4, 'quantity_needed' => 120.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 74, 'product_id' => 10, 'material_id' => 5, 'quantity_needed' => 180.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 75, 'product_id' => 10, 'material_id' => 6, 'quantity_needed' => 5.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 76, 'product_id' => 10, 'material_id' => 7, 'quantity_needed' => 36.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 77, 'product_id' => 10, 'material_id' => 8, 'quantity_needed' => 86.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 78, 'product_id' => 10, 'material_id' => 9, 'quantity_needed' => 550.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 79, 'product_id' => 11, 'material_id' => 1, 'quantity_needed' => 145.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 80, 'product_id' => 11, 'material_id' => 2, 'quantity_needed' => 6.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 81, 'product_id' => 11, 'material_id' => 3, 'quantity_needed' => 4.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 82, 'product_id' => 11, 'material_id' => 4, 'quantity_needed' => 150.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 83, 'product_id' => 11, 'material_id' => 5, 'quantity_needed' => 215.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 84, 'product_id' => 11, 'material_id' => 6, 'quantity_needed' => 6.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 85, 'product_id' => 11, 'material_id' => 7, 'quantity_needed' => 43.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 86, 'product_id' => 11, 'material_id' => 8, 'quantity_needed' => 103.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 87, 'product_id' => 11, 'material_id' => 9, 'quantity_needed' => 650.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 88, 'product_id' => 12, 'material_id' => 1, 'quantity_needed' => 170.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 89, 'product_id' => 12, 'material_id' => 2, 'quantity_needed' => 7.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 90, 'product_id' => 12, 'material_id' => 3, 'quantity_needed' => 4.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 91, 'product_id' => 12, 'material_id' => 4, 'quantity_needed' => 150.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 92, 'product_id' => 12, 'material_id' => 5, 'quantity_needed' => 250.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 93, 'product_id' => 12, 'material_id' => 6, 'quantity_needed' => 7.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 94, 'product_id' => 12, 'material_id' => 7, 'quantity_needed' => 50.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 95, 'product_id' => 12, 'material_id' => 8, 'quantity_needed' => 120.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 96, 'product_id' => 12, 'material_id' => 9, 'quantity_needed' => 750.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 97, 'product_id' => 13, 'material_id' => 1, 'quantity_needed' => 70.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 98, 'product_id' => 13, 'material_id' => 2, 'quantity_needed' => 6.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 99, 'product_id' => 13, 'material_id' => 3, 'quantity_needed' => 3.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 100, 'product_id' => 13, 'material_id' => 5, 'quantity_needed' => 90.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 101, 'product_id' => 13, 'material_id' => 10, 'quantity_needed' => 125.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 102, 'product_id' => 13, 'material_id' => 11, 'quantity_needed' => 15.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 103, 'product_id' => 13, 'material_id' => 12, 'quantity_needed' => 10.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 104, 'product_id' => 13, 'material_id' => 13, 'quantity_needed' => 100.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 105, 'product_id' => 14, 'material_id' => 1, 'quantity_needed' => 350.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 106, 'product_id' => 14, 'material_id' => 2, 'quantity_needed' => 6.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 107, 'product_id' => 14, 'material_id' => 3, 'quantity_needed' => 4.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 108, 'product_id' => 14, 'material_id' => 4, 'quantity_needed' => 200.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 109, 'product_id' => 14, 'material_id' => 5, 'quantity_needed' => 300.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 110, 'product_id' => 14, 'material_id' => 14, 'quantity_needed' => 370.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 111, 'product_id' => 15, 'material_id' => 1, 'quantity_needed' => 170.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 112, 'product_id' => 15, 'material_id' => 2, 'quantity_needed' => 7.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 113, 'product_id' => 15, 'material_id' => 3, 'quantity_needed' => 4.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 114, 'product_id' => 15, 'material_id' => 4, 'quantity_needed' => 150.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 115, 'product_id' => 15, 'material_id' => 5, 'quantity_needed' => 250.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 116, 'product_id' => 15, 'material_id' => 7, 'quantity_needed' => 50.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 117, 'product_id' => 15, 'material_id' => 8, 'quantity_needed' => 120.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 118, 'product_id' => 16, 'material_id' => 1, 'quantity_needed' => 200.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 119, 'product_id' => 16, 'material_id' => 2, 'quantity_needed' => 4.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 120, 'product_id' => 16, 'material_id' => 4, 'quantity_needed' => 80.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 121, 'product_id' => 16, 'material_id' => 5, 'quantity_needed' => 170.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 122, 'product_id' => 16, 'material_id' => 7, 'quantity_needed' => 70.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 123, 'product_id' => 16, 'material_id' => 8, 'quantity_needed' => 300.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 124, 'product_id' => 16, 'material_id' => 10, 'quantity_needed' => 100.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 125, 'product_id' => 17, 'material_id' => 1, 'quantity_needed' => 740.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 126, 'product_id' => 17, 'material_id' => 2, 'quantity_needed' => 2.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 127, 'product_id' => 17, 'material_id' => 4, 'quantity_needed' => 20.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 128, 'product_id' => 17, 'material_id' => 5, 'quantity_needed' => 150.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 129, 'product_id' => 17, 'material_id' => 10, 'quantity_needed' => 180.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 130, 'product_id' => 18, 'material_id' => 1, 'quantity_needed' => 420.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 131, 'product_id' => 18, 'material_id' => 2, 'quantity_needed' => 7.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 132, 'product_id' => 18, 'material_id' => 3, 'quantity_needed' => 4.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 133, 'product_id' => 18, 'material_id' => 4, 'quantity_needed' => 150.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 134, 'product_id' => 18, 'material_id' => 5, 'quantity_needed' => 315.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 135, 'product_id' => 18, 'material_id' => 6, 'quantity_needed' => 7.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 136, 'product_id' => 19, 'material_id' => 1, 'quantity_needed' => 140.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 137, 'product_id' => 19, 'material_id' => 2, 'quantity_needed' => 6.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 138, 'product_id' => 19, 'material_id' => 4, 'quantity_needed' => 80.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 139, 'product_id' => 19, 'material_id' => 5, 'quantity_needed' => 160.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 140, 'product_id' => 19, 'material_id' => 15, 'quantity_needed' => 120.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 141, 'product_id' => 19, 'material_id' => 16, 'quantity_needed' => 2.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 142, 'product_id' => 19, 'material_id' => 17, 'quantity_needed' => 2.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 143, 'product_id' => 20, 'material_id' => 1, 'quantity_needed' => 420.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 144, 'product_id' => 20, 'material_id' => 2, 'quantity_needed' => 8.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 145, 'product_id' => 20, 'material_id' => 3, 'quantity_needed' => 4.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 146, 'product_id' => 20, 'material_id' => 4, 'quantity_needed' => 150.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 147, 'product_id' => 20, 'material_id' => 5, 'quantity_needed' => 315.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 148, 'product_id' => 20, 'material_id' => 15, 'quantity_needed' => 120.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 149, 'product_id' => 20, 'material_id' => 16, 'quantity_needed' => 2.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 150, 'product_id' => 21, 'material_id' => 1, 'quantity_needed' => 500.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 151, 'product_id' => 21, 'material_id' => 2, 'quantity_needed' => 6.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 152, 'product_id' => 21, 'material_id' => 3, 'quantity_needed' => 8.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 153, 'product_id' => 21, 'material_id' => 5, 'quantity_needed' => 450.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 154, 'product_id' => 21, 'material_id' => 11, 'quantity_needed' => 20.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 155, 'product_id' => 21, 'material_id' => 15, 'quantity_needed' => 500.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 156, 'product_id' => 21, 'material_id' => 16, 'quantity_needed' => 3.0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 157, 'product_id' => 21, 'material_id' => 18, 'quantity_needed' => 400.0, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
