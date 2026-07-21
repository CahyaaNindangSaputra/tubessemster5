<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kasir Riels - Modern Dashboard</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --primary-color: #4361ee; --secondary-color: #3f37c9; --success-color: #10b981;
            --warning-color: #f59e0b; --danger-color: #ef4444; --info-color: #3b82f6;
            --bg-color: #f8fafc; --text-dark: #1e293b; --text-muted: #64748b;
        }
        body { background-color: var(--bg-color); font-family: 'Plus Jakarta Sans', sans-serif; color: var(--text-dark); overflow-x: hidden; }
        
        /* Sidebar Styling */
        .sidebar-right { width: 280px; position: fixed; right: 0; top: 0; height: 100vh; background: white; border-left: 1px solid #e2e8f0; padding: 35px 25px; z-index: 1000; box-shadow: -4px 0 20px rgba(0,0,0,0.02); display: flex; flex-direction: column; justify-content: space-between; }
        .nav-sidebar .nav-link { color: var(--text-muted); font-weight: 600; padding: 14px 18px; border-radius: 12px; margin-bottom: 8px; width: 100%; transition: all 0.3s ease; border: 1px solid transparent; text-align: left; }
        .nav-sidebar .nav-link:hover { background-color: #f8fafc; color: var(--primary-color); }
        .nav-sidebar .nav-link.active { background-color: #eff6ff; color: var(--primary-color); border: 1px solid #dbeafe; box-shadow: none; }
        .nav-sidebar .nav-link i { font-size: 1.1rem; vertical-align: middle; margin-bottom: 2px; }
        
        .main-content { margin-right: 280px; padding: 40px; }

        /* Summary Cards */
        .summary-card { border: none; border-radius: 20px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03); transition: transform 0.3s ease; overflow: hidden; background: white; border: 1px solid #e2e8f0; }
        .summary-card:hover { transform: translateY(-4px); }
        .summary-icon { width: 50px; height: 50px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 12px; }
        .summary-title { font-size: 0.8rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; }
        .summary-value { font-size: 1.6rem; font-weight: 800; color: var(--text-dark); line-height: 1.2; }

        /* Meja Cards Styling */
        .card-meja { border: 1px solid #e2e8f0; border-radius: 14px; background: white; transition: all 0.2s ease; position: relative; overflow: hidden; }
        .card-meja:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,0.05); border-color: var(--primary-color); }
        .meja-indicator { width: 100%; height: 5px; position: absolute; top: 0; left: 0; }
        .meja-kosong .meja-indicator { background-color: var(--success-color); }
        .meja-terisi .meja-indicator { background-color: var(--danger-color); }

        /* Modern Containers & Tables */
        .card-modern { background: white; border: 1px solid #e2e8f0; border-radius: 20px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02); overflow: hidden; margin-bottom: 24px; }
        .card-header-modern { padding: 20px 24px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: white; }
        .card-title-modern { font-size: 1rem; font-weight: 700; margin-bottom: 0; display: flex; align-items: center; gap: 8px; }
        
        .table-scroll-container { max-height: 380px; overflow-y: auto; background: white; }
        .table-scroll-container::-webkit-scrollbar { width: 5px; }
        .table-scroll-container::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; }
        
        .table thead th { background-color: #f8fafc; color: #475569; font-weight: 700; font-size: 0.75rem; text-transform: uppercase; padding: 14px 18px; border-bottom: 2px solid #e2e8f0; position: sticky; top: 0; z-index: 10; letter-spacing: 0.5px; }
        .table tbody td { padding: 14px 18px; border-bottom: 1px solid #f1f5f9; font-size: 0.9rem; vertical-align: middle; }
        
        .img-menu { width: 45px; height: 45px; object-fit: cover; border-radius: 10px; border: 1px solid #eee; }
        .btn-modern { border-radius: 50px; padding: 6px 18px; font-weight: 600; font-size: 0.85rem; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .modal-content { border: none; border-radius: 20px; }
    </style>
</head>
<body>

    <!-- Sidebar Kanan -->
    <div class="sidebar-right">
        <div class="bg-white px-3 py-2 rounded-pill shadow-sm border d-flex align-items-center">
            <span class="spinner-grow spinner-grow-sm text-success me-2" role="status"></span>
            <small class="text-success fw-bold">Live Update Aktif</small>
        </div>
        <div>
            <div class="text-center mb-5">
                <h4 class="fw-bold mb-1" style="color: var(--primary-color); letter-spacing: -1px; font-size: 1.6rem;">RIEL'S<span style="color: var(--text-dark)">COFFE</span></h4>
                <p class="text-muted small fw-medium">Sistem Kasir Pintar</p>
            </div>
            
            <div class="nav flex-column nav-pills nav-sidebar" id="v-pills-tab" role="tablist">
                <button class="nav-link active" id="nav-pos-tab" data-bs-toggle="pill" data-bs-target="#nav-pos" type="button">
                    <i class="bi bi-grid-1x2-fill me-2"></i> Monitor Pesanan
                </button>
                <button class="nav-link" id="nav-menu-tab" data-bs-toggle="pill" data-bs-target="#nav-menu" type="button">
                    <i class="bi bi-cup-hot-fill me-2"></i> Kelola Menu
                </button>
            </div>
        </div>
        <div class="text-center text-muted small pb-2">
            &copy; 2026 Riels Coffee
        </div>
    </div>

    <!-- Konten Utama -->
    <div class="main-content">
        <div class="tab-content" id="v-pills-tabContent">
            
            <!-- Tab Monitor Pesanan -->
            <div class="tab-pane fade show active" id="nav-pos">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="fw-bold mb-1 text-dark">Dashboard Kasir</h2>
                        <p class="text-muted mb-0 small">Monitor aktivitas meja dan pesanan restoran secara real-time.</p>
                    </div>
                    <div class="bg-white px-3 py-2 rounded-pill shadow-sm border d-flex align-items-center">
                        <small class="text-muted fw-bold"><i class="bi bi-calendar-event me-2 text-primary"></i> {{ date('d M Y') }}</small>
                        <button onclick="window.location.reload()" class="btn btn-sm btn-light rounded-circle ms-3 shadow-sm border" title="Refresh Data"><i class="bi bi-arrow-clockwise"></i></button>
                    </div>
                </div>

                <!-- Kartu Ringkasan (Summary) -->
                <div class="row mb-4 g-3">
                    <div class="col-md-3">
                        <div class="card summary-card p-3 h-100">
                            <div class="summary-icon bg-primary bg-opacity-10 text-primary"><i class="bi bi-receipt"></i></div>
                            <div class="summary-title">Total Pesanan</div>
                            <div class="summary-value">{{ $riwayatSelesai->count() + count($menungguBayar) + count($sedangProses) }}</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card summary-card p-3 h-100">
                            <div class="summary-icon bg-success bg-opacity-10 text-success"><i class="bi bi-cash-stack"></i></div>
                            <div class="summary-title">Omset Hari Ini</div>
                            <div class="summary-value fs-5">Rp {{ number_format($riwayatSelesai->sum('TOTAL_BAYAR'), 0, ',', '.') }}</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card summary-card p-3 h-100">
                            <div class="summary-icon bg-warning bg-opacity-10 text-warning"><i class="bi bi-fire"></i></div>
                            <div class="summary-title">Pesanan Aktif</div>
                            <div class="summary-value">{{ count($menungguBayar) + count($sedangProses) }}</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card summary-card p-3 h-100">
                            <div class="summary-icon bg-info bg-opacity-10 text-info"><i class="bi bi-grid-3x3-gap-fill"></i></div>
                            <div class="summary-title">Meja Terisi</div>
                            <div class="summary-value">{{ count($mejaTerisi) }} / {{ count($daftarMeja) }}</div>
                        </div>
                    </div>
                </div>

                <!-- Status Meja Section -->
                <div class="card card-modern p-4 mb-4">
                    <h6 class="fw-bold mb-3 text-secondary text-uppercase fs-7"><i class="bi bi-grid me-2 text-primary"></i> Status Meja Restoran</h6>
                    <div class="row g-2">
                        @foreach($daftarMeja as $meja)
                            <div class="col-6 col-md-4 col-lg-2">
                                @php $terisi = in_array($meja->ID_MEJA, $mejaTerisi); @endphp
                                <div class="card-meja {{ $terisi ? 'meja-terisi' : 'meja-kosong' }} shadow-sm">
                                    <div class="meja-indicator"></div>
                                    <div class="card-body text-center py-3 px-2">
                                        <h6 class="fw-bold mb-1">{{ $meja->ID_MEJA }}</h6>
                                        <span class="badge {{ $terisi ? 'bg-danger' : 'bg-success' }} bg-opacity-10 text-{{ $terisi ? 'danger' : 'success' }} rounded-pill px-2 py-1 fw-bold" style="font-size: 0.7rem;">
                                            {{ $terisi ? 'Terisi' : 'Tersedia' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Tabel Utama: Menunggu Pembayaran & Pesanan Aktif -->
                <div class="row g-4">
                    <!-- Kolom Kiri: Menunggu Pembayaran & Pesanan Aktif -->
                    <div class="col-lg-6">
                        <!-- Menunggu Pembayaran -->
                        <div class="card-modern mb-4">
                            <div class="card-header-modern">
                                <h6 class="card-title-modern text-danger"><i class="bi bi-wallet2"></i> Menunggu Pembayaran</h6>
                                @if(count($menungguBayar) > 0) <span class="badge bg-danger rounded-pill px-2 py-1" style="font-size: 0.75rem;">{{ count($menungguBayar) }} Pesanan</span> @endif
                            </div>
                            <div class="table-scroll-container">
                                <table class="table table-hover align-middle mb-0">
                                    <thead><tr><th>ID</th><th>Meja</th><th class="text-end">Total</th><th class="text-center">Aksi</th></tr></thead>
                                    <tbody id="list-menunggu-bayar">
                                        @forelse($menungguBayar as $p)
                                        <tr id="row-bayar-{{ $p->ID_PESANAN }}">
                                            <td class="fw-bold text-primary">#{{ $p->ID_PESANAN }}</td>
                                            <td><span class="badge bg-dark rounded-pill px-2 py-1" style="font-size: 0.75rem;">Meja {{ $p->ID_MEJA }}</span></td>
                                            <td class="fw-bold text-end">Rp {{ number_format($p->TOTAL_BAYAR, 0, ',', '.') }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-success btn-modern text-white rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalBayar{{ $p->ID_PESANAN }}">
                                                    <i class="bi bi-check-lg me-1"></i> Proses
                                                </button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr><td colspan="4" class="text-center py-4 text-muted small"><i class="bi bi-wallet2 fs-3 d-block mb-2 opacity-25"></i>Tidak ada antrean bayar</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Pesanan Aktif -->
                        <div class="card-modern">
                            <div class="card-header-modern">
                                <h6 class="card-title-modern text-primary"><i class="bi bi-list-check"></i> Pesanan Aktif (Dapur)</h6>
                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2 py-1" style="font-size: 0.75rem;">
                                    {{ count($sedangProses) }} Aktif
                                </span>
                            </div>
                            <div class="table-scroll-container">
                                <table class="table table-hover align-middle mb-0">
                                    <thead><tr><th>ID</th><th>Meja</th><th>Status</th><th class="text-end">Aksi</th></tr></thead>
                                    <tbody id="list-sedang-proses">
                                        @forelse($sedangProses as $p)
                                        <tr>
                                            <td class="fw-bold text-primary">#{{ $p->ID_PESANAN }}</td>
                                            <td><span class="badge bg-dark rounded-pill px-2 py-1" style="font-size: 0.75rem;">Meja {{ $p->ID_MEJA }}</span></td>
                                            <td>
                                                @if(empty($p->STATUS_PESANAN) || $p->STATUS_PESANAN == 'Antre')
                                                    <span class="badge bg-warning text-dark rounded-pill px-2 py-1" style="font-size: 0.7rem;">Antre</span>
                                                @elseif($p->STATUS_PESANAN == 'Proses')
                                                    <span class="badge bg-info text-dark rounded-pill px-2 py-1" style="font-size: 0.7rem;">Proses</span>
                                                @elseif($p->STATUS_PESANAN == 'Dimasak')
                                                    <span class="badge bg-primary text-white rounded-pill px-2 py-1 timer-badge" style="font-size: 0.7rem;" data-time="{{ \Carbon\Carbon::parse($p->updated_at)->addMinutes(15)->timestamp }}">
                                                        Menghitung...
                                                    </span>
                                                @elseif($p->STATUS_PESANAN == 'Siap')
                                                    <span class="badge bg-success text-white rounded-pill px-2 py-1" style="font-size: 0.7rem;">Siap Diantar</span>
                                                @else
                                                    <span class="badge bg-secondary rounded-pill px-2 py-1" style="font-size: 0.7rem;">{{ $p->STATUS_PESANAN }}</span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <div class="d-flex gap-1 justify-content-end align-items-center">
                                                    @if(empty($p->STATUS_PESANAN) || $p->STATUS_PESANAN == 'Antre' || $p->STATUS_PESANAN == 'Proses')
                                                        <form action="{{ route('kasir.kirimDapur', $p->ID_PESANAN) }}" method="POST" class="ajax-form-status d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-primary rounded-pill px-2 py-1 fw-bold shadow-sm" style="font-size: 0.75rem;">
                                                                <i class="bi bi-send-fill me-1"></i> Kirim
                                                            </button>
                                                        </form>
                                                    @elseif($p->STATUS_PESANAN == 'Siap')
                                                        <form action="{{ route('kasir.selesai', $p->ID_PESANAN) }}" method="POST" class="ajax-form-status d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success rounded-pill px-2 py-1 fw-bold shadow-sm" style="font-size: 0.75rem;">
                                                                <i class="bi bi-check-all me-1"></i> Selesai
                                                            </button>
                                                        </form>
                                                    @endif
                                                    
                                                    <a href="{{ route('cetak.dapur', $p->ID_PESANAN) }}" target="_blank" class="btn btn-sm btn-dark rounded-circle text-white shadow-sm" style="width: 28px; height: 28px; display:inline-flex; align-items:center; justify-content:center;" title="Cetak Bon Dapur">
                                                        <i class="bi bi-printer-fill" style="font-size: 0.75rem;"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr><td colspan="4" class="text-center py-4 text-muted small"><i class="bi bi-inbox fs-3 d-block mb-2 opacity-25"></i>Tidak ada pesanan aktif</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan: Riwayat Selesai -->
                    <div class="col-lg-6">
                        <div class="card-modern h-100 d-flex flex-column">
                            <div class="card-header-modern flex-wrap gap-2">
                                <h6 class="card-title-modern text-success"><i class="bi bi-clock-history"></i> Riwayat Selesai</h6>
                                <div class="d-flex gap-2">
                                    <form action="{{ route('kasir.dashboard') }}" method="GET" class="d-flex align-items-center">
                                        <div class="input-group input-group-sm shadow-sm rounded-pill overflow-hidden">
                                            <input type="date" name="tanggal" class="form-control border-0 bg-light px-3" value="{{ $tanggalFilter }}" onchange="this.form.submit()" style="font-size: 0.75rem;">
                                        </div>
                                    </form>
                                    <a href="{{ route('kasir.export', ['tanggal' => $tanggalFilter]) }}" class="btn btn-sm btn-success rounded-pill shadow-sm px-3" style="font-size: 0.75rem;"><i class="bi bi-file-earmark-spreadsheet me-1"></i> Excel</a>
                                </div>
                            </div>
                            <div class="table-scroll-container flex-grow-1" style="max-height: 400px;">
                                <table class="table table-hover align-middle mb-0 text-center">
                                    <thead><tr><th>Jam</th><th>ID</th><th>Total</th><th>Aksi</th></tr></thead>
                                    <tbody>
                                        @forelse($riwayatSelesai as $p)
                                        <tr>
                                            <td class="small text-muted">{{ $p->pembayaran ? \Carbon\Carbon::parse($p->pembayaran->WAKTU_PEMBAYARAN)->setTimezone('Asia/Jakarta')->format('H:i') : '-' }}</td>
                                            <td class="fw-bold small">#{{ $p->ID_PESANAN }}</td>
                                            <td class="fw-bold text-success small">Rp {{ number_format($p->TOTAL_BAYAR, 0, ',', '.') }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-1">
                                                    <button class="btn btn-sm btn-light rounded-circle border shadow-sm" style="width: 28px; height: 28px; display:inline-flex; align-items:center; justify-content:center;" data-bs-toggle="modal" data-bs-target="#detailPesanan{{ $p->ID_PESANAN }}"><i class="bi bi-eye" style="font-size: 0.75rem;"></i></button>
                                                    <a href="{{ route('cetak.struk', $p->ID_PESANAN) }}" target="_blank" class="btn btn-sm btn-dark rounded-circle text-white shadow-sm" style="width: 28px; height: 28px; display:inline-flex; align-items:center; justify-content:center;"><i class="bi bi-printer-fill" style="font-size: 0.75rem;"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr><td colspan="4" class="text-center py-5 text-muted small"><i class="bi bi-clock-history fs-2 d-block mb-2 opacity-25"></i>Belum ada data riwayat.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="p-3 border-top bg-white mt-auto">
                                <div class="d-flex justify-content-between align-items-center bg-success-subtle p-3 rounded-4 shadow-sm border border-success-subtle">
                                    <div>
                                        <small class="text-success fw-bold text-uppercase d-block" style="font-size: 0.7rem;">TOTAL OMSET HARI INI</small>
                                        <span class="badge bg-success rounded-pill px-2 py-0.5 mt-1" style="font-size: 0.7rem;">{{ \Carbon\Carbon::parse($tanggalFilter)->format('d M Y') }}</span>
                                    </div>
                                    <h4 class="fw-bold text-success mb-0">Rp {{ number_format($riwayatSelesai->sum('TOTAL_BAYAR'), 0, ',', '.') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Kelola Menu -->
            <div class="tab-pane fade" id="nav-menu">
                <!-- Konten Menu -->
            </div>

        </div>
    </div>

    <!-- Modals Container (Detail Pesanan & Pembayaran) -->
    <div id="modals-container">
        @php $semuaPesanan = $menungguBayar->merge($sedangProses)->merge($riwayatSelesai); @endphp
        @foreach($semuaPesanan as $p)
            <!-- Modal Detail -->
            <div class="modal fade" id="detailPesanan{{ $p->ID_PESANAN }}" tabindex="-1"><div class="modal-dialog modal-dialog-centered modal-lg"><div class="modal-content shadow-lg"><div class="modal-header bg-light border-0"><h5 class="fw-bold">Detail Pesanan #{{ $p->ID_PESANAN }}</h5><button class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body p-0"><table class="table table-striped mb-0"><tbody>@foreach($p->detail as $item)<tr><td class="ps-4">{{ $item->menu->NAMA_MENU ?? 'Menu Dihapus' }}</td><td class="fw-bold text-center">x{{ $item->QTY }}</td><td class="text-end pe-4">Rp {{ number_format($item->SUBTOTAL, 0, ',', '.') }}</td></tr>@endforeach</tbody><tfoot class="bg-white"><tr><td colspan="2" class="ps-4 fw-bold">TOTAL BAYAR</td><td class="text-end pe-4 fw-bold text-primary">Rp {{ number_format($p->TOTAL_BAYAR, 0, ',', '.') }}</td></tr></tfoot></table></div></div></div></div>
            
            <!-- Modal Bayar (Otomatis Terkunci ke Metode Tunai) -->
            <div class="modal fade" id="modalBayar{{ $p->ID_PESANAN }}" tabindex="-1">
                <div class="modal-dialog modal-sm modal-dialog-centered">
                    <div class="modal-content shadow-lg border-0">
                        <div class="modal-header bg-success text-white border-0 justify-content-center"><h5 class="fw-bold">Konfirmasi Bayar Tunai</h5></div>
                        <form action="{{ route('pesanan.bayar', $p->ID_PESANAN) }}" method="POST" class="ajax-form-bayar" data-id="{{ $p->ID_PESANAN }}">
                            @csrf
                            <div class="modal-body text-center p-4">
                                <small class="text-muted d-block mb-1">Total Tagihan</small>
                                <h3 class="fw-bold text-success mb-3">Rp {{ number_format($p->TOTAL_BAYAR, 0, ',', '.') }}</h3>
                                
                                @php
                                    $metodeTunai = collect($metodeBayar)->first(function($item) {
                                        return stripos($item->NAMA_METODE, 'Tunai') !== false;
                                    });
                                @endphp

                                <!-- Input tersembunyi ID metode Tunai otomatis -->
                                <input type="hidden" name="id_metode" value="{{ $metodeTunai->ID_METODE ?? '' }}">
                                
                                <div class="alert alert-success py-2 px-3 mb-0 rounded-pill small fw-bold">
                                    <i class="bi bi-cash-coin me-1"></i> Metode: Tunai (Bayar di Kasir)
                                </div>
                            </div>
                            <div class="p-3 pt-0"><button class="btn btn-success w-100 rounded-pill btn-sm fw-bold">Terima Pembayaran</button></div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Script Javascript Lengkap dengan Real-Time Polling Menyeluruh -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if(session('success')) Swal.fire({icon:'success', title:'Berhasil!', text:'{{ session('success') }}', timer:2000, showConfirmButton:false}); @endif
            @if(session('error')) Swal.fire({icon:'error', title:'Gagal!', text:'{{ session('error') }}'}); @endif

            let lastMainTab = localStorage.getItem('lastMainTab') || 'nav-pos-tab';
            let mainTabElement = document.querySelector(`#${lastMainTab}`);
            if(mainTabElement) new bootstrap.Tab(mainTabElement).show();
            document.querySelectorAll('.nav-sidebar .nav-link').forEach(btn => { btn.addEventListener('shown.bs.tab', e => localStorage.setItem('lastMainTab', e.target.id)); });

            function bindActions() {
                document.querySelectorAll('.ajax-form-bayar').forEach(form => {
                    let newForm = form.cloneNode(true); form.parentNode.replaceChild(newForm, form);
                    newForm.addEventListener('submit', function(e) {
                        e.preventDefault(); let btn=this.querySelector('button'); btn.innerHTML='Loading...'; btn.disabled=true;
                        let id=this.getAttribute('data-id'); let modal=bootstrap.Modal.getInstance(document.getElementById(`modalBayar${id}`)) || new bootstrap.Modal(document.getElementById(`modalBayar${id}`));
                        fetch(this.action, {method:'POST', body:new FormData(this), headers:{'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content}}).then(res=>{if(res.ok){modal.hide(); Swal.fire({icon:'success',title:'Sukses!',timer:1000,showConfirmButton:false}); loadDashboardData();}}).catch(err=>{console.error(err);btn.disabled=false;});
                    });
                });
                document.querySelectorAll('.ajax-form-status').forEach(form => {
                    let newForm = form.cloneNode(true); form.parentNode.replaceChild(newForm, form);
                    newForm.addEventListener('submit', function(e) {
                        e.preventDefault(); let btn=this.querySelector('button'); btn.innerHTML='...';
                        fetch(this.action, {method:'POST', body:new FormData(this), headers:{'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content}}).then(res=>{if(res.ok){loadDashboardData();}});
                    });
                });
            }

            bindActions();

            function loadDashboardData() {
                fetch(window.location.href)
                    .then(response => response.text())
                    .then(html => {
                        let parser = new DOMParser();
                        let doc = parser.parseFromString(html, 'text/html');
                        
                        let summaryRow = document.querySelector('.row.mb-4.g-3');
                        let newSummaryRow = doc.querySelector('.row.mb-4.g-3');
                        if (summaryRow && newSummaryRow) { summaryRow.innerHTML = newSummaryRow.innerHTML; }

                        let mejaSection = document.querySelector('.card.card-modern.p-4.mb-4');
                        let newMejaSection = doc.querySelector('.card.card-modern.p-4.mb-4');
                        if (mejaSection && newMejaSection) { mejaSection.innerHTML = newMejaSection.innerHTML; }

                        let targetBayar = document.getElementById('list-menunggu-bayar');
                        let newTargetBayar = doc.getElementById('list-menunggu-bayar');
                        if (targetBayar && newTargetBayar) { targetBayar.innerHTML = newTargetBayar.innerHTML; }

                        let targetProses = document.getElementById('list-sedang-proses');
                        let newTargetProses = doc.getElementById('list-sedang-proses');
                        if (targetProses && newTargetProses) { targetProses.innerHTML = newTargetProses.innerHTML; }

                        let riwayatContainer = document.querySelector('.col-lg-6:nth-child(2) .card-modern');
                        let newRiwayatContainer = doc.querySelector('.col-lg-6:nth-child(2) .card-modern');
                        if (riwayatContainer && newRiwayatContainer) { riwayatContainer.innerHTML = newRiwayatContainer.innerHTML; }

                        let modalsContainer = document.getElementById('modals-container');
                        let newModalsContainer = doc.getElementById('modals-container');
                        if (modalsContainer && newModalsContainer) { modalsContainer.innerHTML = newModalsContainer.innerHTML; }

                        bindActions();
                    })
                    .catch(err => console.log('Update real-time gagal:', err));
            }
            
            setInterval(loadDashboardData, 10000);

            function updateTimers() {
                document.querySelectorAll('.timer-badge').forEach(function (badge) {
                    const targetTime = parseInt(badge.getAttribute('data-time')) * 1000;
                    const now = new Date().getTime();
                    const distance = targetTime - now;

                    if (distance < 0) {
                        badge.innerHTML = "Waktu Habis / Siap";
                        badge.className = "badge bg-success text-white rounded-pill px-2 py-1";
                    } else {
                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                        badge.innerHTML = `Estimasi: ${minutes}m ${seconds}s`;
                    }
                });
            }

            setInterval(updateTimers, 1000);
            updateTimers();
        });
    </script>
</body>
</html>