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
        Schema::table('order_items', function (Blueprint $table) {
            if (! Schema::hasColumn('order_items', 'hpp_per_unit')) {
                $table->decimal('hpp_per_unit', 10, 2)->default(0)->after('price_per_unit')->comment('Historical HPP per unit at order creation time');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            if (Schema::hasColumn('order_items', 'hpp_per_unit')) {
                $table->dropColumn('hpp_per_unit');
            }
        });
    }
};
