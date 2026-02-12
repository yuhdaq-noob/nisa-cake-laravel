<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan - Nisa Cake</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">

    <div class="d-flex flex-column flex-lg-row min-vh-100">
        <x-navbar active="laporan" />

        <div class="flex-grow-1">
            <div class="container py-4 mb-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="mb-0"> Dashboard Keuangan</h3>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-12 col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-3">
                                <h6 class="text-muted small text-uppercase mb-1">Omzet Hari Ini</h6>
                                <h3 class="fw-bold text-dark mb-0" id="cardOmzetToday">Rp 0</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card border-0 shadow-sm h-100 bg-primary text-white">
                            <div class="card-body p-3">
                                <h6 class="text-white-50 small text-uppercase mb-1">Profit Hari Ini</h6>
                                <h3 class="fw-bold mb-0" id="cardProfitToday">Rp 0</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-3">
                                <h6 class="text-muted small text-uppercase mb-1">Profit Bulan Ini</h6>
                                <h3 class="fw-bold text-dark mb-0" id="cardProfitMonth">Rp 0</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white fw-bold"> Grafik 10 Transaksi Terakhir</div>
                    <div class="card-body">
                        <div style="position: relative; height:300px; width:100%">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header bg-white d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                        <h5 class="mb-0">Rincian Transaksi</h5>
                        <div class="d-flex gap-2 w-100 w-md-auto justify-content-end">
                            <div class="btn-group">
                                <button type="button" class="btn btn-outline-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Export
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" id="btnExportExcel">Excel (.xlsx)</a></li>
                                    <li><a class="dropdown-item" href="#" id="btnExportPdf">PDF (.pdf)</a></li>
                                </ul>
                            </div>
                            <input type="text" id="searchInput" class="form-control w-auto" placeholder="Cari pelanggan / produk..." style="min-width: 200px;">
                            <select id="filterWaktu" class="form-select w-auto">
                                <option value="all">Semua Waktu</option> <option value="today">Hari Ini</option>
                                <option value="last7">7 Hari Terakhir</option>
                                <option value="month">Bulan Ini</option>
                                <option value="last_month">Bulan Lalu</option>
                                <option value="year">Tahun Ini</option>
                            </select>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                          <table class="table table-striped table-hover mb-0 align-middle">
                              <thead class="table-dark">
                                  <tr>
                                      <th>ID</th>
                                      <th style="min-width: 120px;">Tanggal</th>
                                      <th style="min-width: 150px;">Pelanggan</th>
                                      <th>Produk</th>
                                      <th class="text-end">Omzet</th>
                                      <th class="text-end">HPP</th>
                                      <th class="text-end">PROFIT</th>
                                  </tr>
                              </thead>
                              <tbody id="tabelLaporan">
                                  <tr><td colspan="7" class="text-center py-4">Memuat data...</td></tr>
                              </tbody>
                              <tfoot>
                                  <tr class="fw-bold table-secondary">
                                      <td colspan="4" class="text-end">TOTAL:</td>

                                      <td id="tableTotalOmzet" class="text-end">Rp 0</td>
                                      <td id="tableTotalHPP" class="text-end">Rp 0</td>
                                      <td id="tableTotalProfit" class="text-success text-end">Rp 0</td>
                                  </tr>
                              </tfoot>
                          </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/laporan.js'])
</body>
</html>