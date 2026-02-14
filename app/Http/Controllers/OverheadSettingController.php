<?php

namespace App\Http\Controllers;

use App\Models\OverheadSetting;
use Illuminate\Http\JsonResponse;

class OverheadSettingController extends Controller
{
    /**
     * Return overhead settings used in HPP calculation.
     */
    public function index(): JsonResponse
    {
        $settings = OverheadSetting::query()
            ->orderBy('key')
            ->get()
            ->map(function (OverheadSetting $setting) {
                return [
                    'key' => $setting->key,
                    'label' => $this->humanLabel($setting->key),
                    'value' => (float) $setting->value,
                    'unit' => $setting->unit,
                ];
            });

        return response()->json($settings);
    }

    private function humanLabel(string $key): string
    {
        return match ($key) {
            'gas_price_per_tube' => 'Harga Gas per Tabung',
            'gas_capacity_minutes' => 'Kapasitas Gas (menit)',
            'electricity_rate_kwh' => 'Tarif Listrik per kWh',
            'safety_margin_percent' => 'Safety Margin (%)',
            'labor_rate_per_hour' => 'Tarif Tenaga Kerja per Jam',
            'depreciation_per_batch' => 'Biaya Penyusutan per Batch',
            default => str_replace('_', ' ', ucfirst($key)),
        };
    }
}
