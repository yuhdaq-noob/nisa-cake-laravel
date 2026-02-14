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
        Schema::create('product_materials', function (Blueprint $table) {
            $table->id();

            // Kunci ke tabel Products (Kue apa?)
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');

            // Kunci ke tabel Materials (Bahannya apa?)
            $table->foreignId('material_id')->constrained('materials')->onDelete('cascade');

            // Inti BOM: Berapa banyak yang dibutuhkan?
            $table->integer('quantity_needed'); // misal: 200 (gram)

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_materials');
    }
};
