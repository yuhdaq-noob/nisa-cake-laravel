<?php

// FIXME: PERHITUNGAN

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            // Link ke tabel Orders
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');

            // Link ke tabel Products
            $table->foreignId('product_id')->constrained('products');

            $table->integer('quantity'); // Beli berapa biji?

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
