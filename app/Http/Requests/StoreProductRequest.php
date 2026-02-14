<?php

// FIXME: PERHITUNGAN

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:products,name',
            'selling_price' => 'required|numeric|min:0|max:99999999.99',
            // FIXME: TIDAK DIPAKAI
            // production_cost belum dipakai untuk HPP otomatis/laporan (HPP dihitung dari BOM + overhead_cost_per_unit).
            'production_cost' => 'nullable|numeric|min:0|max:99999999.99',
            'overhead_cost_per_unit' => 'nullable|numeric|min:0|max:99999999.99',
            'description' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama produk harus diisi',
            'name.unique' => 'Nama produk sudah ada',
            'selling_price.required' => 'Harga jual harus diisi',
            'selling_price.numeric' => 'Harga jual harus berupa angka',
            'selling_price.min' => 'Harga jual tidak boleh negatif',
            'production_cost.numeric' => 'Biaya produksi harus berupa angka',
            'production_cost.min' => 'Biaya produksi tidak boleh negatif',
            'overhead_cost_per_unit.numeric' => 'Biaya overhead harus berupa angka',
            'overhead_cost_per_unit.min' => 'Biaya overhead tidak boleh negatif',
        ];
    }
}
