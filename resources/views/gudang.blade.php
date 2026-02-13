@extends('layouts.app')
@php($title = 'Gudang & Inventaris')
@php($active = 'gudang')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <div>
            <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Inventaris</p>
            <h2 class="text-2xl font-bold text-slate-900">Manajemen Stok</h2>
        </div>
        <div class="flex flex-wrap gap-2">
            <button class="btn-prim inline-flex items-center gap-2" data-modal-open="modalRestock">
                <i class="bi bi-cart-plus-fill"></i>
                <span>Belanja Bahan</span>
            </button>
            <button type="button" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 px-4 py-2.5 font-semibold text-slate-700 bg-white shadow-sm hover:border-slate-300" data-modal-open="modalKurangStok">
                <i class="bi bi-exclamation-triangle-fill text-amber-600"></i>
                <span>Catat Kerusakan</span>
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-rose-800">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid gap-4 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white rounded-2xl shadow-card border border-slate-100">
                <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                    <p class="text-sm font-semibold text-slate-900">Stok Fisik Saat Ini</p>
                    <span class="text-xs text-slate-500">Live update</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full table-basic text-sm">
                        <thead>
                            <tr>
                                <th class="text-left">Nama Bahan</th>
                                <th class="text-left">Harga/Satuan Baku</th>
                                <th class="text-left">Stok</th>
                                <th class="text-left">Satuan</th>
                                <th class="text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody id="tabelStok">
                            <tr><td colspan="5" class="text-center py-4 text-slate-500">Memuat data...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="bg-white rounded-2xl shadow-card border border-slate-100 h-full">
                <div class="px-5 py-4 border-b border-slate-100">
                    <p class="text-sm font-semibold text-slate-900">Riwayat Keluar/Masuk</p>
                </div>
                <div class="max-h-[320px] overflow-y-auto">
                    <ul class="divide-y divide-slate-100" id="listLog">
                        <li class="px-5 py-4 text-center text-slate-500">Memuat riwayat...</li>
                    </ul>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-card border border-slate-100 h-full">
                <div class="px-5 py-4 border-b border-slate-100">
                    <p class="text-sm font-semibold text-slate-900">Riwayat Perubahan Harga</p>
                </div>
                <div class="max-h-[320px] overflow-y-auto">
                    <ul class="divide-y divide-slate-100" id="listPriceLog">
                        <li class="px-5 py-4 text-center text-slate-500">Memuat riwayat harga...</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Restock -->
    <div id="modalRestock" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-slate-900/50" data-modal-close="modalRestock"></div>
        <div class="relative z-10 flex items-center justify-center min-h-screen px-4">
            <div class="w-full max-w-lg bg-white rounded-2xl shadow-card border border-slate-100">
                <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                    <div>
                        <p class="text-sm font-semibold text-slate-900">Input Belanja Bahan</p>
                        <p class="text-xs text-slate-500">Catat restock bahan baku</p>
                    </div>
                    <button class="p-2 text-slate-500 hover:bg-slate-100 rounded-lg" data-modal-close="modalRestock" aria-label="Tutup">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <form id="formRestock" class="px-5 py-4 space-y-4">
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-800">Pilih Bahan Baku</label>
                        <select id="selectBahan" class="w-full rounded-lg border border-slate-200 px-3 py-2 focus:border-amber-500 focus:ring-2 focus:ring-amber-200" required>
                            <option value="" disabled selected>-- Pilih Bahan --</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-800">Jumlah Masuk (Restock)</label>
                        <input type="number" id="inputJumlah" class="w-full rounded-lg border border-slate-200 px-3 py-2 focus:border-amber-500 focus:ring-2 focus:ring-amber-200" min="1" placeholder="Contoh: 5000" required>
                        <p class="text-xs text-slate-500">Masukkan angka sesuai satuan bahan.</p>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-800">Keterangan (Opsional)</label>
                        <input type="text" id="inputKet" class="w-full rounded-lg border border-slate-200 px-3 py-2 focus:border-amber-500 focus:ring-2 focus:ring-amber-200" placeholder="Contoh: Belanja di Pasar Besar">
                    </div>
                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-700" data-modal-close="modalRestock">Batal</button>
                        <button type="submit" class="btn-prim">Simpan Stok</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Catat Kerusakan -->
    <div id="modalKurangStok" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-slate-900/50" data-modal-close="modalKurangStok"></div>
        <div class="relative z-10 flex items-center justify-center min-h-screen px-4">
            <div class="w-full max-w-lg bg-white rounded-2xl shadow-card border border-slate-100">
                <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                    <div>
                        <p class="text-sm font-semibold text-rose-700">Catat Pengurangan Stok</p>
                        <p class="text-xs text-slate-500">Kerusakan atau susut stok</p>
                    </div>
                    <button class="p-2 text-slate-500 hover:bg-slate-100 rounded-lg" data-modal-close="modalKurangStok" aria-label="Tutup">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <form action="{{ route('materials.reduce') }}" method="POST" class="px-5 py-4 space-y-4">
                    @csrf
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-800">Pilih Bahan Baku</label>
                        <select name="material_id" class="w-full rounded-lg border border-slate-200 px-3 py-2 focus:border-amber-500 focus:ring-2 focus:ring-amber-200" required>
                            <option value="">-- Pilih Bahan --</option>
                            @foreach($materials as $m)
                                <option value="{{ $m->id }}">
                                    {{ $m->name }} (Sisa: {{ $m->current_stock }} {{ $m->unit }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-800">Jumlah Berkurang</label>
                        <input type="number" name="amount" class="w-full rounded-lg border border-slate-200 px-3 py-2 focus:border-amber-500 focus:ring-2 focus:ring-amber-200" min="1" placeholder="Contoh: 5" required>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-800">Keterangan / Alasan</label>
                        <textarea name="description" class="w-full rounded-lg border border-slate-200 px-3 py-2 focus:border-amber-500 focus:ring-2 focus:ring-amber-200" rows="3" placeholder="Wajib diisi! Contoh: Telur pecah atau tepung basah." required></textarea>
                    </div>
                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-700" data-modal-close="modalKurangStok">Batal</button>
                        <button type="submit" class="px-4 py-2 rounded-lg bg-rose-600 text-white font-semibold shadow-card">Simpan Catatan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @vite(['resources/js/gudang.js'])
@endsection
