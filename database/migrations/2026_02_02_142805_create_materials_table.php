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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            // Nama Bahan (misal: Tepung)
            $table->string('unit');
            // Satuan (gram, butir, ml)
            $table->integer('price_per_unit');
            // Harga per satuan (Rp) -> Kunci HPP
            $table->integer('current_stock')->default(0);
            // Stok awal 0
            $table->integer('min_stock_level')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
