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
        Schema::table('materials', function (Blueprint $table) {
            // Add base unit column if it doesn't exist
            if (! Schema::hasColumn('materials', 'unit_baku')) {
                $table->string('unit_baku')->default('gram')->after('unit');
            }

            // Add base unit price column if it doesn't exist
            if (! Schema::hasColumn('materials', 'price_per_unit_baku')) {
                $table->decimal('price_per_unit_baku', 10, 2)->nullable()->after('price_per_unit');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn(['unit_baku', 'price_per_unit_baku']);
        });
    }
};
