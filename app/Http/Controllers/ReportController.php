<?php

// FIXME: PERHITUNGAN

namespace App\Http\Controllers;

use App\Exports\LaporanExport;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Get all orders with their items for reporting
     */
    public function index(): AnonymousResourceCollection
    {
        $orders = Order::with('items.product')
            ->orderBy('created_at', 'desc')
            ->get();

        return OrderResource::collection($orders);
    }

    public function export(Request $request)
    {
        $format = $request->query('format', 'excel');
        // FIXME: TIDAK DIPAKAI
        // period & search sudah dibaca, tapi belum diterapkan untuk filter query export.
        $period = $request->query('period', 'all');
        $search = $request->query('search', '');

        // Ambil data order sesuai filter (bisa disesuaikan dengan filter waktu/search)
        $orders = Order::with('items.product')
            ->orderBy('created_at', 'desc')
            ->get();

        // Filter data jika perlu (implementasi filter sesuai kebutuhan frontend)
        // ... (bisa tambahkan filter period & search di sini)

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('exports.laporan_pdf', [
                'orders' => $orders,
            ]);

            return $pdf->download('laporan.pdf');
        } else {
            return Excel::download(new LaporanExport($orders), 'laporan.xlsx');
        }
    }
}
