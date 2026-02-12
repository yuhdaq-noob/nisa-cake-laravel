<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\View\View;

class InventoryController extends Controller
{
    /**
     * Display inventory management page
     */
    public function index(): View
    {
        $materials = Material::orderBy('current_stock', 'asc')->get();

        return view('gudang', compact('materials'));
    }
}
