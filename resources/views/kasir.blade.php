<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>kasir - Nisa Cake</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">

    <div class="d-flex flex-column flex-lg-row min-vh-100">
        <x-navbar active="kasir" />

        <div class="flex-grow-1">
            <div class="container py-4">
                <div class="row">
                    <div class="col-md-5 mb-4">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                                <h6 class="mb-0 fw-bold text-dark">Input Pesanan</h6>
                            </div>
                            <div class="card-body pt-2">
                                <div class="mb-2">
                                    <label class="form-label small text-muted fw-bold mb-1">Nama Pelanggan</label>
                                    <input type="text" id="customer_name" class="form-control form-control-sm" placeholder="Nama Pembeli..." required>
                                    <div id="error_customer_name" class="text-danger small d-none mt-1"></div>
                                </div>

                                <div class="mb-2">
                                    <label class="form-label small text-muted fw-bold mb-1">Pilih Produk</label>
                                    <input class="form-control form-control-sm" list="product_list" id="product_input" placeholder="Ketik nama kue..." autocomplete="off">
                                    <datalist id="product_list"></datalist>
                                    <div id="error_product_input" class="text-danger small d-none mt-1"></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small text-muted fw-bold mb-1">Jumlah</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" id="quantity" class="form-control" value="1" min="1">
                                        <button class="btn btn-outline-secondary px-3" type="button" onclick="tambahKeKeranjang()">
                                            <i class="bi bi-plus-lg"></i> Tambah
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7 mb-4">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-bold text-dark">Keranjang Belanja</h6>
                                <span id="totalDisplay" class="fw-bold fs-5 text-primary">Rp 0</span>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                                    <table class="table table-hover mb-0 align-middle small">
                                        <thead class="table-light sticky-top">
                                            <tr>
                                                <th>Produk</th>
                                                <th class="text-end">Harga</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-end">Subtotal</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tabelKeranjang">
                                            <tr><td colspan="5" class="text-center py-4 text-muted">Keranjang masih kosong.</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer bg-white p-3 border-top-0">
                                <div id="error_checkout" class="text-danger small d-none mb-2 text-center fw-bold"></div>
                                <button onclick="prosesTransaksi()" class="btn btn-primary w-100 py-3 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1H2zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V7z"/>
                                        <path d="M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1z"/>
                                    </svg>
                                    Bayar Sekarang
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/kasir.js'])
</body>
</html>