<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dapur Riels Coffee</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root { --sidebar-width: 280px; }
        body { background-color: #f8fafc; font-family: 'Plus Jakarta Sans', sans-serif; color: #1e293b; overflow-x: hidden; }
        
        /* Sidebar Styling Modern */
        .sidebar-right { width: var(--sidebar-width); position: fixed; right: 0; top: 0; height: 100vh; background: #ffffff; border-left: 1px solid #e2e8f0; padding: 35px 25px; z-index: 1000; display: flex; flex-direction: column; justify-content: space-between; box-shadow: -4px 0 20px rgba(0,0,0,0.02); }
        .sidebar-brand h4 { font-size: 1.25rem; letter-spacing: -0.5px; }
        .sidebar-right .nav-link { border-radius: 12px; font-weight: 600; padding: 12px 18px; color: #64748b; transition: all 0.3s ease; }
        .sidebar-right .nav-link:hover { background-color: #f1f5f9; color: #0d6efd; }
        .sidebar-right .nav-link.active { background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%); color: #ffffff; box-shadow: 0 4px 12px rgba(13, 110, 253, 0.25); }

        /* Main Content Styling */
        .main-content { margin-right: var(--sidebar-width); padding: 40px; min-height: 100vh; }
        
        /* Modern Cards */
        .card-modern { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 24px; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.04), 0 8px 10px -6px rgba(0, 0, 0, 0.04); overflow: hidden; margin-bottom: 24px; }
        .card-header-modern { padding: 22px 25px; border-bottom: 1px solid #f1f5f9; font-weight: 700; display: flex; justify-content: space-between; align-items: center; background: #ffffff; font-size: 1.05rem; }
        
        /* Table Optimization */
        .table thead th { background-color: #f8fafc; color: #64748b; text-transform: uppercase; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px; padding: 16px 20px; border-bottom: 1px solid #e2e8f0; }
        .table tbody td { padding: 18px 20px; vertical-align: middle; border-bottom: 1px solid #f1f5f9; color: #334155; font-weight: 500; }
        .table tbody tr:hover { background-color: #f8fafc; }

        /* Custom Badges & Buttons */
        .badge-meja { background: #0f172a; color: #ffffff; font-weight: 600; padding: 6px 14px; border-radius: 50px; font-size: 0.8rem; }
        .btn-action-cook { border-radius: 50px; padding: 8px 16px; font-size: 0.82rem; transition: all 0.2s; }
        .cooking-card-item { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 18px 20px; margin-bottom: 14px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02); display: flex; justify-content: space-between; align-items: center; transition: all 0.2s ease; }
        .cooking-card-item:hover { border-color: #cbd5e1; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

    <!-- Sidebar Modern -->
    <div class="sidebar-right">
        <div>
            <div class="text-center mb-5 sidebar-brand">
                <h4 class="fw-bold mb-1" style="color: #0d6efd;"><i class="bi bi-cup-hot-fill me-1"></i> RIEL'S<span style="color: #0f172a">COFFE</span></h4>
                <p class="text-muted small fw-medium mb-0">Dapur Pintar & Manajemen</p>
            </div>
            
            <!-- Tombol Navigasi Sidebar Kanan -->
            <div class="nav flex-column nav-pills gap-2">
                <a href="{{ url('/dapur') }}" class="nav-link active d-flex align-items-center">
                    <i class="bi bi-fire fs-5 me-3"></i> Monitor Dapur
                </a>
                <a href="{{ route('dapur.resep.index') }}" class="nav-link d-flex align-items-center">
                    <i class="bi bi-journal-text fs-5 me-3"></i> Kelola Resep
                </a>
            </div>
        </div>
        <div class="text-center text-muted small pb-2">
            &copy; 2026 Riels Coffee
        </div>
    </div>

    <!-- Main Content Dapur -->
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Dashboard Dapur</h2>
                <p class="text-muted small mb-0">Kelola antrean dan status masakan pesanan masuk secara real-time.</p>
            </div>
            <!-- Indikator Real-Time -->
            <div>
                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill fw-bold">
                    <span class="spinner-grow spinner-grow-sm text-success me-1" role="status"></span> Live Update Aktif
                </span>
            </div>
        </div>
        
        <div class="row g-4" id="dapur-container">
            <!-- Kolom Antrean Pesanan (Status: Antre) -->
            <div class="col-lg-7">
                <div class="card-modern">
                    <div class="card-header-modern text-danger">
                        <span><i class="bi bi-clock-history me-2"></i> Antrean Pesanan</span>
                        <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2 fw-bold" style="font-size: 0.8rem;">
                            {{ isset($pesananAntre) ? count($pesananAntre) : 0 }} Antrean
                        </span>
                    </div>
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>ID PESANAN</th>
                                    <th>MEJA</th>
                                    <th class="text-end">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pesananAntre as $p)
                                <tr>
                                    <td class="fw-bold text-primary">#{{ $p->ID_PESANAN }}</td>
                                    <td><span class="badge-meja">Meja {{ $p->ID_MEJA }}</span></td>
                                    <td class="text-end">
                                        <form action="{{ route('dapur.updateStatus', $p->ID_PESANAN) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-warning btn-action-cook fw-bold text-dark shadow-sm">
                                                <i class="bi bi-play-fill me-1"></i> Mulai Masak
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-2 d-block mb-2 text-black-50"></i>
                                        <small class="fw-medium">Tidak ada antrean pesanan saat ini.</small>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="p-3 bg-white border-top text-end">
                        @if(isset($pesananAntre) && count($pesananAntre) > 0)
                        <a href="{{ route('cetak.semua.antrean') }}" target="_blank" class="btn btn-primary rounded-pill fw-bold shadow-sm px-4 py-2" onclick="setTimeout(() => window.location.reload(), 1000)">
                            <i class="bi bi-printer-fill me-2"></i> Cetak Semua Struk Antrean
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Kolom Sedang Dimasak (Status: Dimasak) -->
            <div class="col-lg-5">
                <div class="card-modern h-100 d-flex flex-column">
                    <div class="card-header-modern text-warning">
                        <span><i class="bi bi-fire me-2"></i> Sedang Dimasak</span>
                        <span class="badge bg-warning bg-opacity-20 text-dark rounded-pill px-3 py-2 fw-bold" style="font-size: 0.8rem;">
                            {{ isset($pesananDimasak) ? count($pesananDimasak) : 0 }} Aktif
                        </span>
                    </div>
                    <div class="card-body p-3 flex-grow-1" style="max-height: 450px; overflow-y: auto;">
                        @forelse($pesananDimasak as $p)
                            <div class="cooking-card-item">
                                <div>
                                    <strong class="text-dark d-block fs-6 mb-1">#{{ $p->ID_PESANAN }}</strong>
                                    <span class="badge-meja">Meja {{ $p->ID_MEJA }}</span>
                                </div>
                                <form action="{{ route('dapur.updateStatus', $p->ID_PESANAN) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success btn-action-cook fw-bold shadow-sm">
                                        <i class="bi bi-check-lg me-1"></i> Selesai
                                    </button>
                                </form>
                            </div>
                        @empty
                            <div class="text-center py-5 text-muted">
                                <i class="bi bi-cup-hot fs-2 d-block mb-2 text-black-50"></i>
                                <p class="small fw-medium mb-0">Dapur santai, belum ada masakan aktif.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // AUTO REFRESH / REAL-TIME POLLING SETIAP 5 DETIK TANPA MERUSAK TAMPILAN
        setInterval(function() {
            fetch(window.location.href)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newContainer = doc.getElementById('dapur-container');
                    if (newContainer) {
                        document.getElementById('dapur-container').innerHTML = newContainer.innerHTML;
                    }
                })
                .catch(error => console.error('Gagal memperbarui data real-time:', error));
        }, 5000); 
    </script>
</body>
</html>