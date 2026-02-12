<?php

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
        if (! Schema::hasColumn('materials', 'min_stock_level')) {
            Schema::table('materials', function (Blueprint $table) {
                // Tambahkan kolom untuk menyimpan batas stok minimum, setelah kolom current_stock
                $table->integer('min_stock_level')->default(1000)->after('current_stock');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materials', fn (Blueprint $table) => $table->dropColumn('min_stock_level'));
    }
};
