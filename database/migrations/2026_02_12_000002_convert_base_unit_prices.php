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
            "  END\n".
            "WHERE\n".
            "  (unit_baku IS NULL OR unit_baku = unit)\n".
            '  AND (price_per_unit_baku IS NULL OR price_per_unit_baku = price_per_unit)'
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement(
            "UPDATE materials\n".
            "SET\n".
            "  unit_baku = unit,\n".
            "  price_per_unit_baku = price_per_unit\n".
            "WHERE\n".
            "  unit_baku IN ('kg', 'liter')\n".
            '  AND (price_per_unit_baku IS NOT NULL)'
        );
    }
};
