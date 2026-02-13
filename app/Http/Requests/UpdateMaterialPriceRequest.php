<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMaterialPriceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'price_per_unit_baku' => 'required|numeric|min:0.01',
        ];
    }

    public function messages(): array
    {
        return [
            'price_per_unit_baku.required' => 'Harga per kg wajib diisi.',
            'price_per_unit_baku.numeric' => 'Harga harus berupa angka (contoh: 35000 untuk Rp 35.000).',
            'price_per_unit_baku.min' => 'Harga minimal 0.01.',
        ];
    }
}
