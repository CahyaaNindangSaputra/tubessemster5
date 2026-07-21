<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Panel Supplier - Riels Coffee</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --primary-color: #4361ee;
            --success-color: #10b981;
            --bg-color: #f8fafc;
            --text-dark: #1e293b;
            --text-muted: #64748b;
        }
        body { background-color: var(--bg-color); font-family: 'Plus Jakarta Sans', sans-serif; color: var(--text-dark); overflow-x: hidden; }
        
        /* Sidebar Modern */
        .sidebar { width: 260px; position: fixed; left: 0; top: 0; height: 100vh; background: white; border-right: 1px solid #e2e8f0; padding: 30px 20px; z-index: 1000; display: flex; flex-direction: column; justify-content: space-between; }
        .sidebar-brand h4 { font-size: 1.5rem; letter-spacing: -0.5px; }
        .nav-sidebar .nav-link { color: var(--text-muted); font-weight: 600; padding: 12px 16px; border-radius: 12px; margin-bottom: 8px; transition: all 0.3s ease; }
        .nav-sidebar .nav-link:hover { background-color: #f1f5f9; color: var(--primary-color); }
        .nav-sidebar .nav-link.active { background-color: #eff6ff; color: var(--primary-color); box-shadow: none; }
        .nav-sidebar .nav-link i { font-size: 1.1rem; margin-right: 12px; }

        /* Main Content Area */
        .main-content { margin-left: 260px; padding: 40px; }
        
        /* Modern Cards */
        .card-modern { background: white; border: 1px solid #e2e8f0; border-radius: 20px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02); overflow: hidden; margin-bottom: 24px; transition: all 0.2s ease; }
        .card-modern-clickable:hover { transform: translateY(-3px); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05); border-color: #cbd5e1; }
        .card-header-modern { padding: 20px 24px; border-bottom: 1px solid #e2e8f0; font-weight: 700; display: flex; justify-content: space-between; align-items: center; background: white; }
        
        /* Tables & Thumbnail */
        .table thead th { background-color: #f8fafc; color: var(--text-muted); font-weight: 700; font-size: 0.8rem; text-transform: uppercase; padding: 16px; border-bottom: 2px solid #e2e8f0; letter-spacing: 0.5px; }
        .table tbody td { padding: 16px; border-bottom: 1px solid #f1f5f9; font-size: 0.95rem; vertical-align: middle; }
        .img-thumb { width: 45px; height: 45px; object-fit: cover; border-radius: 12px; border: 1px solid #e2e8f0; }

        /* Katalog Grid Card */
        .catalog-card { background: white; border: 1px solid #e2e8f0; border-radius: 20px; overflow: hidden; transition: transform 0.2s; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02); }
        .catalog-card:hover { transform: translateY(-4px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
        .catalog-card.catalog-kritis { border: 2px solid #dc3545 !important; background-color: #fff5f5; }
        .catalog-img-wrapper { height: 180px; width: 100%; overflow: hidden; background: #f1f5f9; position: relative; }
        .catalog-img-wrapper img { width: 100%; height: 100%; object-fit: cover; }
    </style>
</head>
<body>

    <!-- Sidebar Supplier -->
    <div class="sidebar">
        <div>
            <div class="text-center mb-5 sidebar-brand">
                <h4 class="fw-bold mb-1" style="color: var(--primary-color);">RIEL'S<span style="color: var(--text-dark)">COFFE</span></h4>
                <p class="text-muted small fw-medium">Panel Supplier</p>
            </div>
            
            <div class="nav flex-column nav-pills nav-sidebar" id="supplierTab" role="tablist">
                <button class="nav-link active text-start" id="tab-dashboard" data-bs-toggle="pill" data-bs-target="#content-dashboard" type="button">
                    <i class="bi bi-grid-1x2-fill"></i> Dashboard
                </button>
                <button class="nav-link text-start" id="tab-stok" data-bs-toggle="pill" data-bs-target="#content-stok" type="button">
                    <i class="bi bi-box-seam-fill"></i> Manajemen Stok
                </button>
                <button class="nav-link text-start" id="tab-katalog" data-bs-toggle="pill" data-bs-target="#content-katalog" type="button">
                    <i class="bi bi-card-image"></i> Katalog Bahan
                </button>
            </div>
        </div>
        <!-- Indikator Live Update Sidebar -->
        <div class="bg-light p-3 rounded-4 border text-center">
            <span class="spinner-grow spinner-grow-sm text-success me-1" role="status"></span>
            <small class="text-success fw-bold" style="font-size: 0.75rem;">Live Update Aktif</small>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="tab-content" id="supplierTabContent">
            
            <!-- 1. TAB DASHBOARD -->
            <div class="tab-pane fade show active" id="content-dashboard">
                <div class="mb-4">
                    <h2 class="fw-bold mb-1 text-dark">Dashboard Supplier</h2>
                    <p class="text-muted small">Ringkasan ketersediaan suplai bahan baku dan rekapitulasi pengeluaran Riels Coffee.</p>
                </div>

                <!-- Ringkasan Statistik 4 Kolom -->
                <div class="row g-4 mb-4">
                    <div class="col-md-3">
                        <div class="card-modern p-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-4 fs-3 me-3"><i class="bi bi-boxes"></i></div>
                                <div>
                                    <span class="text-muted small fw-bold text-uppercase">Total Jenis Bahan</span>
                                    <h3 class="fw-bold mb-0 text-dark">{{ isset($daftarBahan) ? count($daftarBahan) : 0 }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card-modern p-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-4 fs-3 me-3"><i class="bi bi-wallet2"></i></div>
                                <div>
                                    <span class="text-muted small fw-bold text-uppercase">Total Valuasi Aset</span>
                                    <h6 class="fw-bold mb-0 text-dark">
                                        Rp {{ number_format(isset($daftarBahan) ? $daftarBahan->sum(function($item) { return $item->harga * $item->JUMLAH_BAHAN; }) : 0, 0, ',', '.') }}
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Kotak Pengeluaran 1 Minggu (Bisa Diklik) -->
                    <div class="col-md-3">
                        <div class="card-modern card-modern-clickable p-4" role="button" data-bs-toggle="modal" data-bs-target="#modalPengeluaranMingguan" style="cursor: pointer;" title="Klik untuk lihat rincian pengeluaran">
                            <div class="d-flex align-items-center">
                                <div class="bg-success bg-opacity-10 text-success p-3 rounded-4 fs-3 me-3"><i class="bi bi-cash-stack"></i></div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted small fw-bold text-uppercase">Pengeluaran 1 Minggu</span>
                                        <i class="bi bi-box-arrow-up-right text-success small"></i>
                                    </div>
                                    <h6 class="fw-bold mb-0 text-success">
                                        Rp {{ number_format($totalPengeluaranMingguan ?? 0, 0, ',', '.') }}
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Rincian Pengeluaran 1 Minggu -->
<div class="modal fade" id="modalPengeluaranMingguan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="fw-bold text-success"><i class="bi bi-cash-stack me-2"></i> Rincian Pengeluaran 7 Hari Terakhir</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <p class="text-muted small">Daftar barang masuk/pembelian yang masuk dalam hitungan pengeluaran mingguan:</p>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>TGL MASUK</th>
                                <th>ID BAHAN</th>
                                <th>NAMA BAHAN</th>
                                <th>JUMLAH</th>
                                <th>HARGA SATUAN</th>
                                <th>TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($laporanMasuk ?? [] as $b)
                            <tr>
                                <td><span class="badge bg-light text-dark border">{{ $b->tanggal_masuk }}</span></td>
                                <td class="fw-bold text-primary">{{ $b->id_bahan }}</td>
                                <td class="fw-semibold">{{ $b->nama_bahan }}</td>
                                <td>{{ $b->jumlah_masuk }} {{ $b->satuan }}</td>
                                <td>Rp {{ number_format($b->harga_satuan, 0, ',', '.') }}</td>
                                <td class="fw-bold text-success">Rp {{ number_format($b->harga_satuan * $b->jumlah_masuk, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted small">Tidak ada data pengeluaran dalam 7 hari terakhir.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer border-top-0 pt-0 d-flex justify-content-between">
                <!-- Tombol Export Excel di dalam Modal -->
                <a href="{{ route('supplier.exportExcel', ['bulan' => $bulanPilih ?? date('Y-m')]) }}" class="btn btn-success rounded-pill px-4 fw-bold">
                    <i class="bi bi-file-earmark-excel me-1"></i> Export Excel
                </a>
                <button type="button" class="btn btn-secondary rounded-pill px-4 fw-semibold" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

                    <div class="col-md-3">
                        <div class="card-modern card-modern-clickable p-4" role="button" data-bs-toggle="modal" data-bs-target="#modalStokKritis" style="cursor: pointer;" title="Klik untuk lihat rincian stok kritis">
                            <div class="d-flex align-items-center">
                                @if(isset($bahanMenipis) && count($bahanMenipis) > 0)
                                    <div class="bg-danger bg-opacity-10 text-danger p-3 rounded-4 fs-3 me-3"><i class="bi bi-exclamation-triangle"></i></div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-muted small fw-bold text-uppercase">Status</span>
                                            <i class="bi bi-box-arrow-up-right text-danger small"></i>
                                        </div>
                                        <h5 class="fw-bold mb-0 text-danger">Stok Kritis!</h5>
                                    </div>
                                @else
                                    <div class="bg-success bg-opacity-10 text-success p-3 rounded-4 fs-3 me-3"><i class="bi bi-check-circle"></i></div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-muted small fw-bold text-uppercase">Status</span>
                                            <i class="bi bi-check text-success"></i>
                                        </div>
                                        <h5 class="fw-bold mb-0 text-success">Aman</h5>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rekapitulasi Riwayat Jejak Barang Masuk (7 Hari Terakhir) -->
                <div class="card-modern mb-4">
                    <div class="card-header-modern bg-white d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <div>
                            <span class="fw-bold text-primary"><i class="bi bi-calendar-event me-2"></i> Rekapitulasi Jejak Riwayat Masuk</span>
                            <p class="text-muted small mb-0">Menampilkan seluruh jejak restock dalam 7 hari terakhir tanpa tertimpa.</p>
                        </div>
                        
                        <form action="{{ route('supplier.dashboard') }}" method="GET" class="d-flex align-items-center gap-2">
                            <input type="month" name="bulan" class="form-control form-control-sm rounded-pill bg-light border px-3" value="{{ $bulanPilih ?? date('Y-m') }}">
                            <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3 fw-bold">Filter</button>
                            <a href="{{ route('supplier.exportExcel', ['bulan' => $bulanPilih ?? date('Y-m')]) }}" class="btn btn-sm btn-success rounded-pill px-3 fw-bold">
                                <i class="bi bi-file-earmark-excel me-1"></i> Export Excel
                            </a>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>FOTO</th>
                                    <th>TGL MASUK</th>
                                    <th>ID BAHAN</th>
                                    <th>NAMA BAHAN</th>
                                    <th>HARGA SATUAN</th>
                                    <th>JUMLAH MASUK</th>
                                    <th>ESTIMASI TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($laporanMasuk ?? [] as $b)
                                <tr>
                                    <td>
                                        @if(!empty($b->foto) && file_exists(public_path('storage/' . $b->foto)))
                                            <img src="{{ asset('storage/' . $b->foto) }}" alt="Foto" class="img-thumb">
                                        @else
                                            <div class="img-thumb bg-light d-flex align-items-center justify-content-center text-muted small"><i class="bi bi-image"></i></div>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border px-2 py-1 fw-bold">
                                            <i class="bi bi-calendar-check text-primary me-1"></i> {{ $b->tanggal_masuk ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="fw-bold text-primary">{{ $b->id_bahan }}</td>
                                    <td class="fw-semibold">{{ $b->nama_bahan }}</td>
                                    <td>Rp {{ number_format($b->harga_satuan ?? 0, 0, ',', '.') }}</td>
                                    <td>{{ $b->jumlah_masuk }} {{ $b->satuan }}</td>
                                    <td class="fw-bold text-success">Rp {{ number_format(($b->harga_satuan ?? 0) * ($b->jumlah_masuk ?? 0), 0, ',', '.') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted small">Tidak ada jejak riwayat masuk dalam 7 hari terakhir pada bulan ini.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Peringatan Barang Kurang / Di Bawah 1 -->
                <div class="card-modern border-danger shadow-sm">
                    <div class="card-header-modern bg-danger text-white fw-bold">
                        <span><i class="bi bi-exclamation-octagon-fill me-2"></i> Peringatan Stok Kritis (&lt; 1 Unit / Kg / Liter / Botol / Pack)</span>
                        <span class="badge bg-white text-danger px-3 py-1 rounded-pill fw-bold">
                            {{ isset($bahanMenipis) ? count($bahanMenipis) : 0 }} Item
                        </span>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr class="table-danger border-bottom">
                                    <th class="text-danger fw-bold">FOTO</th>
                                    <th class="text-danger fw-bold">ID BAHAN</th>
                                    <th class="text-danger fw-bold">NAMA BAHAN</th>
                                    <th class="text-danger fw-bold">JUMLAH STOK</th>
                                    <th class="text-danger fw-bold">STATUS TINDAKAN</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bahanMenipis ?? [] as $b)
                                <tr class="table-light">
                                    <td>
                                        @if(!empty($b->foto) && file_exists(public_path('storage/' . $b->foto)))
                                            <img src="{{ asset('storage/' . $b->foto) }}" alt="Foto" class="img-thumb border-danger">
                                        @else
                                            <div class="img-thumb bg-white text-danger d-flex align-items-center justify-content-center small border border-danger"><i class="bi bi-image"></i></div>
                                        @endif
                                    </td>
                                    <td class="fw-bold text-danger">{{ $b->id_bahan }}</td>
                                    <td class="fw-semibold text-dark">{{ $b->nama_bahan }}</td>
                                    <td>
                                        <span class="badge bg-danger rounded-pill px-3 py-2 fw-bold text-white" style="background-color: #dc3545 !important;">
                                            <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ $b->JUMLAH_BAHAN }} {{ $b->satuan }}
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-danger rounded-pill px-3 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#restockModal{{ $b->id_bahan }}">
                                            <i class="bi bi-plus-circle me-1"></i> Segera Restock
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted small">
                                        <i class="bi bi-check-circle-fill fs-3 d-block mb-1 text-success"></i>
                                        Luar biasa! Tidak ada stok bahan yang berada di bawah 1 (semua stok terpantau aman).
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- 2. TAB MANAJEMEN STOK -->
            <div class="tab-pane fade" id="content-stok">
                <div class="mb-4">
                    <h2 class="fw-bold mb-1 text-dark">Manajemen Stok Bahan Baku</h2>
                    <p class="text-muted small">Tambah, pantau, dan kelola takaran serta satuan bahan baku gudang.</p>
                </div>

                <div class="row g-4">
                    <!-- Form Tambah Bahan -->
                    <div class="col-lg-4">
                        <div class="card-modern p-4">
                            <h5 class="fw-bold mb-4 text-primary"><i class="bi bi-plus-circle me-2"></i> Tambah Bahan Baru</h5>
                            <form action="{{ route('supplier.storeBahan') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Nama Bahan</label>
                                    <input type="text" name="nama_bahan" class="form-control rounded-pill bg-light border-0 px-3 py-2" placeholder="Cth: Susu UHT" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Foto Bahan Baku</label>
                                    <input type="file" name="foto" class="form-control rounded-pill bg-light border-0 px-3 py-2" accept="image/*">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Harga Satuan (Rp)</label>
                                    <input type="number" name="harga" class="form-control rounded-pill bg-light border-0 px-3 py-2" placeholder="Cth: 15000" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Jumlah / Stok</label>
                                    <input type="number" step="any" name="jumlah_bahan" class="form-control rounded-pill bg-light border-0 px-3 py-2" placeholder="Cth: 50" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Satuan Takaran</label>
                                    <select name="satuan" class="form-select rounded-pill bg-light border-0 px-3 py-2" required>
                                        <option value="">Pilih Satuan...</option>
                                        <option value="Kg">Kilogram (Kg)</option>
                                        <option value="Gram">Gram (g)</option>
                                        <option value="Liter">Liter (L)</option>
                                        <option value="ml">Mililiter (ml)</option>
                                        <option value="Pcs">Pcs / Buah</option>
                                        <option value="Botol">Botol</option>
                                        <option value="Pack">Pack</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label small fw-bold">Tanggal Masuk</label>
                                    <input type="date" name="tanggal_masuk" class="form-control rounded-pill bg-light border-0 px-3 py-2" value="{{ date('Y-m-d') }}" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold shadow-sm py-2">
                                    Simpan Bahan Baku
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Tabel Daftar Stok Gudang -->
                    <div class="col-lg-8">
                        <div class="card-modern">
                            <div class="card-header-modern bg-white">
                                <span class="fw-bold text-dark"><i class="bi bi-table me-2"></i> Daftar Stok Gudang</span>
                            </div>
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>FOTO</th>
                                            <th>ID BAHAN</th>
                                            <th>NAMA BAHAN</th>
                                            <th>HARGA</th>
                                            <th>JUMLAH STOK</th>
                                            <th>TGL MASUK</th>
                                            <th class="text-end">AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($daftarBahan as $b)
                                        <tr>
                                            <td>
                                                @if(!empty($b->foto) && file_exists(public_path('storage/' . $b->foto)))
                                                    <img src="{{ asset('storage/' . $b->foto) }}" alt="Foto" class="img-thumb">
                                                @else
                                                    <div class="img-thumb bg-light d-flex align-items-center justify-content-center text-muted small"><i class="bi bi-image"></i></div>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-link fw-bold text-primary p-0 text-decoration-none" data-bs-toggle="modal" data-bs-target="#modalRiwayatBahan{{ $b->id_bahan }}">
                                                    {{ $b->id_bahan }} <i class="bi bi-eye ms-1 small"></i>
                                                </button>
                                            </td>
                                            <td class="fw-semibold">
                                                <a href="#" class="text-dark text-decoration-none" data-bs-toggle="modal" data-bs-target="#modalRiwayatBahan{{ $b->id_bahan }}">
                                                    {{ $b->nama_bahan }}
                                                </a>
                                            </td>
                                            <td>Rp {{ number_format($b->harga ?? 0, 0, ',', '.') }}</td>
                                            <td>
                                                <span class="badge bg-dark rounded-pill px-3 py-2 fw-bold">
                                                    {{ $b->JUMLAH_BAHAN }} {{ $b->satuan }}
                                                </span>
                                            </td>
                                            <td><small class="text-muted">{{ $b->tanggal_masuk ?? '-' }}</small></td>
                                            <td class="text-end">
                                                <button class="btn btn-sm btn-light border rounded-circle shadow-sm me-1 text-success" title="Restock Stok" data-bs-toggle="modal" data-bs-target="#restockModal{{ $b->id_bahan }}" style="width: 32px; height: 32px;">
                                                    <i class="bi bi-plus-lg"></i>
                                                </button>

                                                <form action="{{ route('supplier.destroyBahan', $b->id_bahan) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus bahan ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-light border rounded-circle shadow-sm text-danger" title="Hapus Stok" style="width: 32px; height: 32px;">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-5 text-muted small">
                                                <i class="bi bi-inbox fs-2 d-block mb-2 opacity-50"></i>
                                                Belum ada data bahan baku yang terdaftar.
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. TAB KATALOG BAHAN -->
            <div class="tab-pane fade" id="content-katalog">
                <div class="mb-4">
                    <h2 class="fw-bold mb-1 text-dark">Katalog Visual Bahan Baku</h2>
                    <p class="text-muted small">Tampilan galeri kartu untuk memantau visual ketersediaan bahan baku di gudang.</p>
                </div>

                <div class="row g-4">
                    @forelse($daftarBahan as $b)
                    <div class="col-md-3">
                        <div class="catalog-card {{ $b->JUMLAH_BAHAN < 1 ? 'catalog-kritis' : '' }}">
                            <div class="catalog-img-wrapper">
                                @if(!empty($b->foto) && file_exists(public_path('storage/' . $b->foto)))
                                    <img src="{{ asset('storage/' . $b->foto) }}" alt="{{ $b->nama_bahan }}">
                                @else
                                    <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center text-muted">
                                        <i class="bi bi-image fs-1 mb-1"></i>
                                        <small class="small">Tanpa Foto</small>
                                    </div>
                                @endif
                                <span class="position-absolute top-0 end-0 badge {{ $b->JUMLAH_BAHAN < 1 ? 'bg-danger text-white' : 'bg-dark' }} m-2 px-3 py-2 rounded-pill shadow-sm">
                                    {{ $b->JUMLAH_BAHAN }} {{ $b->satuan }}
                                </span>
                            </div>
                            <div class="p-3 text-start">
                                <span class="text-primary small fw-bold">{{ $b->id_bahan }}</span>
                                <h6 class="fw-bold text-dark text-truncate mb-1">{{ $b->nama_bahan }}</h6>
                                <p class="text-success fw-bold mb-3">Rp {{ number_format($b->harga ?? 0, 0, ',', '.') }}</p>
                                
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-primary w-50 rounded-pill fw-semibold" data-bs-toggle="modal" data-bs-target="#modalRiwayatBahan{{ $b->id_bahan }}">
                                        <i class="bi bi-clock-history me-1"></i> Riwayat
                                    </button>
                                    <button class="btn btn-sm {{ $b->JUMLAH_BAHAN < 1 ? 'btn-danger' : 'btn-success' }} w-50 rounded-pill fw-semibold text-white" data-bs-toggle="modal" data-bs-target="#restockModal{{ $b->id_bahan }}">
                                        <i class="bi bi-plus-lg me-1"></i> Restock
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        Belum ada data bahan baku dalam katalog.
                    </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    <!-- ======================================================= -->
    <!-- KUMPULAN MODAL DI LUAR TABEL                            -->
    <!-- ======================================================= -->

    <!-- Modal Rincian Pengeluaran 1 Minggu -->
    <div class="modal fade" id="modalPengeluaranMingguan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="fw-bold text-success"><i class="bi bi-cash-stack me-2"></i> Rincian Pengeluaran 7 Hari Terakhir</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <p class="text-muted small">Daftar barang masuk/pembelian yang masuk dalam hitungan pengeluaran mingguan:</p>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>TGL MASUK</th>
                                    <th>ID BAHAN</th>
                                    <th>NAMA BAHAN</th>
                                    <th>JUMLAH</th>
                                    <th>HARGA SATUAN</th>
                                    <th>TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($laporanMasuk ?? [] as $b)
                                <tr>
                                    <td><span class="badge bg-light text-dark border">{{ $b->tanggal_masuk }}</span></td>
                                    <td class="fw-bold text-primary">{{ $b->id_bahan }}</td>
                                    <td class="fw-semibold">{{ $b->nama_bahan }}</td>
                                    <td>{{ $b->jumlah_masuk }} {{ $b->satuan }}</td>
                                    <td>Rp {{ number_format($b->harga_satuan, 0, ',', '.') }}</td>
                                    <td class="fw-bold text-success">Rp {{ number_format($b->harga_satuan * $b->jumlah_masuk, 0, ',', '.') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted small">Tidak ada data pengeluaran dalam 7 hari terakhir.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-secondary rounded-pill px-4 fw-semibold" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Stok Kritis -->
    <div class="modal fade" id="modalStokKritis" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="fw-bold text-danger"><i class="bi bi-exclamation-triangle-fill me-2"></i> Rincian Bahan Baku Stok Kritis (&lt; 1)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <p class="text-muted small">Berikut adalah daftar barang yang memerlukan pengadaan atau restock segera:</p>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>FOTO</th>
                                    <th>ID BAHAN</th>
                                    <th>NAMA BAHAN</th>
                                    <th>JUMLAH STOK</th>
                                    <th>HARGA SATUAN</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bahanMenipis ?? [] as $b)
                                <tr>
                                    <td>
                                        @if(!empty($b->foto) && file_exists(public_path('storage/' . $b->foto)))
                                            <img src="{{ asset('storage/' . $b->foto) }}" alt="Foto" class="img-thumb">
                                        @else
                                            <div class="img-thumb bg-light d-flex align-items-center justify-content-center text-muted small"><i class="bi bi-image"></i></div>
                                        @endif
                                    </td>
                                    <td class="fw-bold text-danger">{{ $b->id_bahan }}</td>
                                    <td class="fw-semibold">{{ $b->nama_bahan }}</td>
                                    <td>
                                        <span class="badge bg-danger rounded-pill px-3 py-2 fw-bold text-white" style="background-color: #dc3545 !important;">
                                            {{ $b->JUMLAH_BAHAN }} {{ $b->satuan }}
                                        </span>
                                    </td>
                                    <td>Rp {{ number_format($b->harga ?? 0, 0, ',', '.') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted small">
                                        <i class="bi bi-check-circle fs-3 d-block mb-1 text-success"></i>
                                        Luar biasa! Tidak ada stok bahan yang berada dalam status kritis.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-secondary rounded-pill px-4 fw-semibold" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Riwayat & Restock Per Item Bahan -->
    @foreach($daftarBahan as $b)
        <!-- Modal Riwayat Masuk per Item -->
        <div class="modal fade" id="modalRiwayatBahan{{ $b->id_bahan }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 rounded-4 shadow">
                    <div class="modal-header border-bottom-0 pb-0">
                        <h5 class="fw-bold text-dark"><i class="bi bi-clock-history text-primary me-2"></i> Riwayat Masuk: {{ $b->nama_bahan }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body py-4 text-start">
                        <p class="text-muted small mb-3">Daftar rekam jejak tanggal, jumlah, dan bukti foto masuk untuk bahan ini (Klik foto untuk memperbesar):</p>
                        <div class="table-responsive">
                            <table class="table table-sm align-middle mb-0">
                                <thead>
                                    <tr class="bg-light">
                                        <th>BUKTI FOTO</th>
                                        <th>TANGGAL MASUK</th>
                                        <th>JUMLAH</th>
                                        <th>HARGA SATUAN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $riwayatItem = \App\Models\RiwayatStok::where('id_bahan', $b->id_bahan)->orderBy('tanggal_masuk', 'desc')->get();
                                    @endphp

                                    @forelse($riwayatItem as $index => $r)
                                    <tr>
                                        <td>
                                            @if(!empty($r->foto) && file_exists(public_path('storage/' . $r->foto)))
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#modalPreviewFoto{{ $b->id_bahan }}{{ $index }}">
                                                    <img src="{{ asset('storage/' . $r->foto) }}" alt="Bukti" style="width: 45px; height: 45px; object-fit: cover; border-radius: 8px; border: 1px solid #cbd5e1;" class="shadow-sm">
                                                </a>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border px-2 py-1 fw-bold">
                                                <i class="bi bi-calendar-check text-primary me-1"></i> {{ $r->tanggal_masuk }}
                                            </span>
                                        </td>
                                        <td class="fw-bold text-success">+{{ $r->jumlah_masuk }} {{ $r->satuan }}</td>
                                        <td>Rp {{ number_format($r->harga_satuan, 0, ',', '.') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-3 text-muted small">Belum ada catatan riwayat masuk untuk bahan ini.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-secondary rounded-pill px-4 fw-semibold" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sub-Modal untuk Preview Foto Ukuran Besar per Baris Riwayat -->
        @foreach(\App\Models\RiwayatStok::where('id_bahan', $b->id_bahan)->get() as $index => $r)
            @if(!empty($r->foto) && file_exists(public_path('storage/' . $r->foto)))
            <div class="modal fade" id="modalPreviewFoto{{ $b->id_bahan }}{{ $index }}" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
                <div class="modal-dialog modal-dialog-centered modal-md">
                    <div class="modal-content border-0 rounded-4 shadow bg-dark text-center p-2">
                        <div class="modal-header border-0 pb-0">
                            <h6 class="text-white fw-bold mb-0">Bukti Foto: {{ $b->nama_bahan }} ({{ $r->tanggal_masuk }})</h6>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-2">
                            <img src="{{ asset('storage/' . $r->foto) }}" alt="Preview Besar" class="img-fluid rounded-3 shadow" style="max-height: 500px; width: auto; object-fit: contain;">
                        </div>
                    </div>
                </div>
            </div>
            @endif
        @endforeach

        <!-- Modal Restock per Item -->
        <div class="modal fade" id="restockModal{{ $b->id_bahan }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 rounded-4 shadow">
                    <div class="modal-header border-bottom-0 pb-0">
                        <h5 class="fw-bold text-dark">Restock Bahan: {{ $b->nama_bahan }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('supplier.restockBahan', $b->id_bahan) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body py-4 text-start">
                            <p class="text-muted small mb-3">Stok saat ini: <strong class="text-dark">{{ $b->JUMLAH_BAHAN }} {{ $b->satuan }}</strong></p>
                            
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Jumlah Tambahan Stok</label>
                                <div class="input-group">
                                    <input type="number" step="any" name="tambah_stok" class="form-control rounded-start-pill bg-light border-0 px-3 py-2" placeholder="Cth: 20" min="0.01" required>
                                    <span class="input-group-text bg-light border-0 rounded-end-pill px-3 text-muted fw-bold">{{ $b->satuan }}</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold">Harga Satuan Terbaru (Rp)</label>
                                <input type="number" name="harga" class="form-control rounded-pill bg-light border-0 px-3 py-2" value="{{ $b->harga }}" placeholder="Cth: 26000" required>
                                <div class="form-text small text-muted">Sesuaikan jika harga dari supplier berubah.</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold">Foto Bukti / Nota Restock</label>
                                <input type="file" name="foto" class="form-control rounded-pill bg-light border-0 px-3 py-2" accept="image/*">
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold">Tanggal Masuk (Restock)</label>
                                <input type="date" name="tanggal_masuk" class="form-control rounded-pill bg-light border-0 px-3 py-2" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="modal-footer border-top-0 pt-0">
                            <button type="button" class="btn btn-light rounded-pill px-4 fw-semibold" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold shadow-sm">Simpan Restock</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Script Bootstrap & Notifikasi + Live Update Polling -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
       document.addEventListener("DOMContentLoaded", function() {
           @if(session('success')) 
               Swal.fire({icon:'success', title:'Berhasil!', text:'{{ session('success') }}', timer:2000, showConfirmButton:false}); 
           @endif
           @if(session('error')) 
               Swal.fire({icon:'error', title:'Gagal!', text:'{{ session('error') }}'}); 
           @endif

           const activeTab = localStorage.getItem('supplierActiveTab');
           if (activeTab) {
               const tabTrigger = document.querySelector(`[data-bs-target="${activeTab}"]`);
               if (tabTrigger) {
                   const tab = new bootstrap.Tab(tabTrigger);
                   tab.show();
               }
           }

           document.querySelectorAll('#supplierTab button').forEach(button => {
               button.addEventListener('shown.bs.tab', event => {
                   localStorage.setItem('supplierActiveTab', event.target.getAttribute('data-bs-target'));
               });
           });
       });

       setInterval(function() {
           if (document.querySelector('.modal.show') || document.activeElement.tagName === 'INPUT' || document.activeElement.tagName === 'SELECT') {
               return;
           }

           fetch(window.location.href, {
               headers: { 'X-Requested-With': 'XMLHttpRequest' }
           })
           .then(response => response.text())
           .then(html => {
               const parser = new DOMParser();
               const doc = parser.parseFromString(html, 'text/html');

               const newStats = doc.querySelector('.row.g-4.mb-4');
               const currentStats = document.querySelector('.row.g-4.mb-4');
               if (newStats && currentStats) {
                   currentStats.innerHTML = newStats.innerHTML;
               }

               const newTabelMasuk = document.querySelector('#content-dashboard .card-modern.mb-4 .table-responsive');
               const currentTabelMasuk = document.querySelector('#content-dashboard .card-modern.mb-4 .table-responsive');
               if (newTabelMasuk && currentTabelMasuk && document.activeElement.name !== 'bulan') {
                   currentTabelMasuk.innerHTML = newTabelMasuk.innerHTML;
               }

               const newStokTable = document.querySelector('#content-stok .table-responsive');
               const currentStokTable = document.querySelector('#content-stok .table-responsive');
               if (newStokTable && currentStokTable) {
                   currentStokTable.innerHTML = newStokTable.innerHTML;
               }
           })
           .catch(error => console.error('Sinkronisasi live background:', error));
       }, 5000);
    </script>
</body>
</html>