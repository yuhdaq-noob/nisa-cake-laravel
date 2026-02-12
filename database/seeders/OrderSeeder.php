<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk membuat dummy orders.
     *
     * Gunakan:
     * php artisan db:seed --class=OrderSeeder
     *
     * Untuk reset orders dan items:
     * php artisan tinker
     * > Order::truncate();
     * > OrderItem::truncate();
     * > exit
     */
    public function run(): void
    {
        // Pastikan ada produk sebelum membuat order
        $products = Product::all();

        if ($products->isEmpty()) {
            $this->command->info('Tidak ada produk! Jalankan MasterDataSeeder terlebih dahulu.');

            return;
        }

        $this->command->info('Membuat dummy orders...');

        // Buat 50 order dengan items di dalamnya
        Order::factory(170)
            ->completed()  // Gunakan orders yang sudah selesai (untuk laporan)
            ->create()
            ->each(function ($order) use ($products) {
                // Setiap order memiliki 1-3 item
                $itemCount = fake()->numberBetween(1, 3);
                $totalPrice = 0;
                $totalHpp = 0;

                // Ambil tanggal dari order_date dan tambahkan jam acak agar created_at tidak seragam
                $timestamp = \Carbon\Carbon::parse($order->order_date)->setTimeFromTimeString(fake()->time());

                for ($i = 0; $i < $itemCount; $i++) {
                    $product = $products->random();
                    $quantity = fake()->numberBetween(1, 2);

                    // Hitung total price dan hpp
                    $totalPrice += $product->selling_price * $quantity;
                    $totalHpp += $product->production_cost * $quantity;

                    // Buat order item
                    $item = OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                    ]);
                    // Update timestamp item agar sesuai order (agar item tidak tercatat hari ini)
                    $item->created_at = $timestamp;
                    $item->updated_at = $timestamp;
                    $item->save();
                }

                // Update order dengan total price dan hpp
                $order->total_price = $totalPrice;
                $order->total_hpp = $totalHpp;
                $order->created_at = $timestamp;
                $order->updated_at = $timestamp;
                $order->save();
            });

        $this->command->info('Berhasil membuat 170 dummy orders dengan order items!');
    }
}
