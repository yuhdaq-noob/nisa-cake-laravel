<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gudang & Inventaris - Nisa Cake</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css', 'resources/css/gudang.css', 'resources/js/gudang.js'])
</head>
<body class="bg-light">

    <div class="d-flex flex-column flex-lg-row min-vh-100">
        <x-navbar active="gudang" />

        <div class="grow">
            <div class="container py-4 mb-5">
                <!-- Header & Action Buttons -->
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <h3 class="mb-0 fw-bold">Manajemen Stok</h3>

                    <div class="d-flex gap-2">
                        <!-- Tombol Belanja (Restock) -->
                        <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalRestock">
                            <i class="bi bi-cart-plus-fill"></i>
                            <span class="d-none d-md-inline ms-1">Belanja Bahan</span>
                        </button>

                        <!-- Tombol Catat Kerusakan -->
                        <button type="button" class="btn btn-outline-secondary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalKurangStok">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <span class="d-none d-md-inline ms-1">Catat Kerusakan</span>
                        </button>
                    </div>
                </div>

                <!-- Alerts Area -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="row g-4">
                    <div class="col-md-8">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white fw-bold">Stok Fisik Saat Ini</div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0 align-middle table-gudang">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Nama Bahan</th>
                                                <th>Harga/Satuan Baku</th>
                                                <th>Stok</th>
                                                <th>Satuan</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tabelStok">
                                            <tr><td colspan="5" class="text-center py-3">Memuat data...</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="row g-3 log-grid">
                            <div class="col-12 col-lg-6">
                                <div class="card shadow-sm log-card h-100">
                                    <div class="card-header bg-white fw-bold">Riwayat Keluar/Masuk</div>
                                    <div class="card-body p-0 log-scroll">
                                        <ul class="list-group list-group-flush" id="listLog">
                                            <li class="list-group-item text-center text-muted py-3">Memuat riwayat...</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="card shadow-sm log-card h-100">
                                    <div class="card-header bg-white fw-bold">Riwayat Perubahan Harga</div>
                                    <div class="card-body p-0 log-scroll">
                                        <ul class="list-group list-group-flush" id="listPriceLog">
                                            <li class="list-group-item text-center text-muted py-3">Memuat riwayat harga...</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODALS (Diletakkan di luar container utama agar tidak tertutup elemen lain) -->

    <!-- Modal Restock -->
    <div class="modal fade" id="modalRestock" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Input Belanja Bahan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="formRestock">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Pilih Bahan Baku</label>
                            <select id="selectBahan" class="form-select" required>
                                <option value="" disabled selected>-- Pilih Bahan --</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jumlah Masuk (Restock)</label>
                            <input type="number" id="inputJumlah" class="form-control" min="1" placeholder="Contoh: 5000" required>
                            <small class="text-muted">Masukkan angka saja (sesuai satuan bahan).</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan (Opsional)</label>
                            <input type="text" id="inputKet" class="form-control" placeholder="Contoh: Belanja di Pasar Besar">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Stok</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Catat Kerusakan -->
    <div class="modal fade" id="modalKurangStok" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">📉 Catat Pengurangan Stok</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('materials.reduce') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Pilih Bahan Baku</label>
                            <select name="material_id" class="form-select" required>
                                <option value="">-- Pilih Bahan --</option>
                                @foreach($materials as $m)
                                    <option value="{{ $m->id }}">
                                        {{ $m->name }} (Sisa: {{ $m->current_stock }} {{ $m->unit }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jumlah Berkurang</label>
                            <input type="number" name="amount" class="form-control" min="1" placeholder="Contoh: 5" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Keterangan / Alasan</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Wajib diisi! Contoh: Telur pecah saat pengiriman, atau Tepung basah kena hujan." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Simpan Catatan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
