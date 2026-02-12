<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReduceStockRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'material_id' => 'required|integer|exists:materials,id',
            'amount' => 'required|integer|min:1',
            'description' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'material_id.required' => 'ID bahan baku wajib diisi.',
            'material_id.exists' => 'Bahan baku yang dipilih tidak ditemukan.',
            'amount.required' => 'Jumlah pengurangan stok wajib diisi.',
            'amount.integer' => 'Jumlah harus berupa angka.',
            'amount.min' => 'Jumlah minimal 1.',
            'description.required' => 'Keterangan pengurangan stok wajib diisi.',
            'description.string' => 'Keterangan harus berupa teks.',
            'description.max' => 'Keterangan maksimal 255 karakter.',
        ];
    }
}
