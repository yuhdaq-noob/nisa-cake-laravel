<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fill unit_baku and price_per_unit_baku for existing materials
        DB::statement('UPDATE materials SET unit_baku = unit, price_per_unit_baku = price_per_unit WHERE unit_baku IS NULL OR price_per_unit_baku IS NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration only populates data, no need to reverse
    }
};
