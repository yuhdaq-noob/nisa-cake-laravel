@extends('layouts.app')
@php($title = 'Kasir')
@php($active = 'kasir')

@section('content')
    <div class="grid gap-4 lg:grid-cols-5">
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white rounded-2xl shadow-card border border-slate-100 h-full">
                <div class="px-5 pt-5 pb-3">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Kasir</p>
                    <h3 class="text-xl font-bold text-slate-900">Input Pesanan</h3>
                </div>
                <div class="px-5 pb-5 space-y-4">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-600">Nama Pelanggan</label>
                        <input type="text" id="customer_name" class="w-full rounded-lg border border-slate-200 px-3 py-2 focus:border-amber-500 focus:ring-2 focus:ring-amber-200" placeholder="Nama Pembeli..." required>
                        <div id="error_customer_name" class="hidden text-sm text-rose-600"></div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-600">Pilih Produk</label>
                        <input class="w-full rounded-lg border border-slate-200 px-3 py-2 focus:border-amber-500 focus:ring-2 focus:ring-amber-200" list="product_list" id="product_input" placeholder="Ketik nama kue..." autocomplete="off">
                        <datalist id="product_list"></datalist>
                        <div id="error_product_input" class="hidden text-sm text-rose-600"></div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-600">Jumlah</label>
                        <div class="flex gap-2">
                            <input type="number" id="quantity" class="w-full rounded-lg border border-slate-200 px-3 py-2 focus:border-amber-500 focus:ring-2 focus:ring-amber-200" value="1" min="1">
                            <button class="px-4 py-2 rounded-lg border border-amber-200 bg-amber-50 text-amber-900 font-semibold hover:bg-amber-100" type="button" onclick="tambahKeKeranjang()">
                                <i class="bi bi-plus-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-3 space-y-4">
            <div class="bg-white rounded-2xl shadow-card border border-slate-100 h-full">
                <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h6 class="text-sm font-semibold text-slate-900">Keranjang Belanja</h6>
                    <span id="totalDisplay" class="text-lg font-bold text-amber-800">Rp 0</span>
                </div>
                <div class="px-2">
                    <div class="overflow-x-auto" style="max-height: 320px;">
                        <table class="min-w-full table-basic text-sm">
                            <thead class="sticky top-0">
                                <tr>
                                    <th class="text-left">Produk</th>
                                    <th class="text-right">Harga</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-right">Subtotal</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tabelKeranjang">
                                <tr><td colspan="5" class="text-center py-4 text-slate-500">Keranjang masih kosong.</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="px-5 py-4 space-y-3 border-t border-slate-100 bg-slate-50 rounded-b-2xl">
                    <div id="error_checkout" class="hidden text-center text-sm font-semibold text-rose-700"></div>
                    <button onclick="prosesTransaksi()" class="btn-prim w-full justify-center text-base">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16" class="w-4 h-4">
                            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1H2zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V7z"/>
                            <path d="M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1z"/>
                        </svg>
                        Bayar Sekarang
                    </button>
                    <div id="orderCompleteBox" class="hidden flex flex-col md:flex-row md:items-center md:justify-between gap-2 border border-slate-200 rounded-xl p-3 bg-white">
                        <div class="text-sm text-slate-600">
                            Pesanan terakhir: <span id="lastOrderId" class="font-semibold text-slate-900">-</span>
                        </div>
                        <button type="button" id="btnCompleteOrder" class="px-3 py-2 rounded-lg bg-emerald-600 text-white text-sm font-semibold shadow-card">Tandai Selesai</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @vite(['resources/js/kasir.js'])
@endsection
