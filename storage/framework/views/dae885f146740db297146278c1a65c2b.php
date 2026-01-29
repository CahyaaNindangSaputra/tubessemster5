<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Kasir Riels - Modern Dashboard</title>
    <link rel="icon" href="<?php echo e(asset('images/logo.png')); ?>" type="image/x-icon">
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --primary-color: #4361ee; --secondary-color: #3f37c9; --success-color: #10b981;
            --warning-color: #f59e0b; --danger-color: #ef4444; --info-color: #3b82f6;
            --bg-color: #f3f4f6; --text-dark: #1e293b; --text-muted: #64748b;
        }
        body { background-color: var(--bg-color); font-family: 'Plus Jakarta Sans', sans-serif; color: var(--text-dark); overflow-x: hidden; }
        
        /* SIDEBAR */
        .sidebar-right { width: 260px; position: fixed; right: 0; top: 0; height: 100vh; background: white; border-left: 1px solid #e2e8f0; padding: 30px 20px; z-index: 1000; box-shadow: -4px 0 20px rgba(0,0,0,0.02); display: flex; flex-direction: column; justify-content: space-between; }
        .nav-sidebar .nav-link { color: var(--text-muted); font-weight: 600; padding: 14px 18px; border-radius: 12px; margin-bottom: 8px; width: 100%; transition: all 0.3s ease; border: 1px solid transparent; text-align: left; }
        .nav-sidebar .nav-link:hover { background-color: #f8fafc; color: var(--primary-color); }
        .nav-sidebar .nav-link.active { background-color: #eff6ff; color: var(--primary-color); border: 1px solid #dbeafe; box-shadow: none; }
        .nav-sidebar .nav-link i { font-size: 1.1rem; vertical-align: middle; margin-bottom: 2px; }

        /* CONTENT */
        .main-content { margin-right: 260px; padding: 40px; }
        
        /* SUMMARY CARDS */
        .summary-card { border: none; border-radius: 20px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05); transition: transform 0.3s ease; overflow: hidden; }
        .summary-card:hover { transform: translateY(-5px); }
        .summary-icon { width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin-bottom: 15px; }
        .summary-title { font-size: 0.9rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; }
        .summary-value { font-size: 2rem; font-weight: 800; color: var(--text-dark); line-height: 1.2; }

        /* CARDS MEJA */
        .card-meja { border: 1px solid #e2e8f0; border-radius: 16px; background: white; transition: all 0.3s; position: relative; overflow: hidden; cursor: pointer; height: 100%; }
        .card-meja:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.08); border-color: var(--primary-color); }
        .meja-indicator { width: 100%; height: 6px; position: absolute; top: 0; left: 0; }
        .meja-kosong .meja-indicator { background-color: var(--success-color); }
        .meja-terisi .meja-indicator { background-color: var(--danger-color); }
        .meja-icon { width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-size: 1.5rem; }
        .meja-kosong .meja-icon { background-color: #d1fae5; color: var(--success-color); }
        .meja-terisi .meja-icon { background-color: #fee2e2; color: var(--danger-color); }

        /* UI ELEMENTS */
        .card-modern { background: white; border: 1px solid #e2e8f0; border-radius: 20px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); overflow: hidden; }
        .card-header-modern { padding: 20px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; }
        .card-title-modern { font-size: 1.1rem; font-weight: 700; margin-bottom: 0; display: flex; align-items: center; }
        
        .table-scroll-container { max-height: 450px; overflow-y: auto; border-radius: 16px; border: 1px solid #e2e8f0; background: white; }
        .table-scroll-container::-webkit-scrollbar { width: 6px; }
        .table-scroll-container::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; }
        .table thead th { background-color: #f8fafc; color: #475569; font-weight: 700; font-size: 0.85rem; text-transform: uppercase; padding: 16px; border-bottom: 2px solid #e2e8f0; position: sticky; top: 0; z-index: 10; }
        .table tbody td { padding: 16px; border-bottom: 1px solid #f1f5f9; font-size: 0.95rem; vertical-align: middle; }

        .img-menu { width: 50px; height: 50px; object-fit: cover; border-radius: 10px; border: 1px solid #eee; }
        .btn-modern { border-radius: 50px; padding: 8px 20px; font-weight: 600; box-shadow: 0 2px 5px rgba(0,0,0,0.05); transition: 0.2s; }
        .modal-content { border: none; border-radius: 20px; }
    </style>
</head>
<body>

    <div class="sidebar-right">
        <div>
            <div class="text-center mb-5">
                <h4 class="fw-bold" style="color: var(--primary-color); letter-spacing: -1px; font-size: 1.8rem;">RIEL'S<span style="color: var(--text-dark)">COFFEE</span></h4>
                <p class="text-muted small">Sistem Kasir Pintar</p>
            </div>
            
            <div class="nav flex-column nav-pills nav-sidebar" id="v-pills-tab" role="tablist">
                <button class="nav-link active" id="nav-pos-tab" data-bs-toggle="pill" data-bs-target="#nav-pos" type="button">
                    <i class="bi bi-grid-1x2-fill me-3"></i> Monitor Pesanan
                </button>
                <button class="nav-link" id="nav-menu-tab" data-bs-toggle="pill" data-bs-target="#nav-menu" type="button">
                    <i class="bi bi-cup-hot-fill me-3"></i> Kelola Menu
                </button>
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="tab-content" id="v-pills-tabContent">
            
            <div class="tab-pane fade show active" id="nav-pos">
                <div class="d-flex justify-content-between align-items-end mb-5">
                    <div>
                        <h1 class="fw-bold mb-2" style="color: var(--text-dark);">Dashboard Kasir</h1>
                        <p class="text-muted mb-0 fs-5">Monitor aktivitas meja dan pesanan restoran secara real-time.</p>
                    </div>
                    <div class="bg-white px-4 py-2 rounded-pill shadow-sm border d-flex align-items-center">
                        <small class="text-muted fw-bold fs-6"><i class="bi bi-calendar-event me-2"></i> <?php echo e(date('d M Y')); ?></small>
                        <button onclick="window.location.reload()" class="btn btn-sm btn-light rounded-circle ms-3 shadow-sm border" title="Refresh Data"><i class="bi bi-arrow-clockwise fs-6"></i></button>
                    </div>
                </div>

                <div class="row mb-5 g-4">
                    <div class="col-md-3">
                        <div class="card summary-card bg-white p-4 h-100">
                            <div class="summary-icon bg-primary bg-opacity-10 text-primary"><i class="bi bi-receipt"></i></div>
                            <div class="summary-title">Total Pesanan Hari Ini</div>
                            <div class="summary-value"><?php echo e($riwayatSelesai->count() + count($menungguBayar) + count($sedangProses)); ?></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card summary-card bg-white p-4 h-100">
                            <div class="summary-icon bg-success bg-opacity-10 text-success"><i class="bi bi-cash-stack"></i></div>
                            <div class="summary-title">Total Omset Hari Ini</div>
                            <div class="summary-value">Rp <?php echo e(number_format($riwayatSelesai->sum('TOTAL_BAYAR'), 0, ',', '.')); ?></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card summary-card bg-white p-4 h-100">
                            <div class="summary-icon bg-warning bg-opacity-10 text-warning"><i class="bi bi-fire"></i></div>
                            <div class="summary-title">Pesanan Aktif</div>
                            <div class="summary-value"><?php echo e(count($menungguBayar) + count($sedangProses)); ?></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card summary-card bg-white p-4 h-100">
                            <div class="summary-icon bg-info bg-opacity-10 text-info"><i class="bi bi-grid-3x3-gap-fill"></i></div>
                            <div class="summary-title">Meja Terisi</div>
                            <div class="summary-value"><?php echo e(count($mejaTerisi)); ?> / <?php echo e(count($daftarMeja)); ?></div>
                        </div>
                    </div>
                </div>

                <h5 class="fw-bold mb-4 text-secondary ps-2 border-start border-4 border-primary">Status Meja</h5>
                <div class="row mb-5 g-3">
                    <?php $__currentLoopData = $daftarMeja; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meja): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-3 col-lg-2">
                            <?php $terisi = in_array($meja->ID_MEJA, $mejaTerisi); ?>
                            <div class="card-meja <?php echo e($terisi ? 'meja-terisi' : 'meja-kosong'); ?> shadow-sm">
                                <div class="meja-indicator"></div>
                                <div class="card-body text-center py-4">
                                    <div class="meja-icon"><i class="bi bi-grid-fill"></i></div>
                                    <h5 class="fw-bold mb-2"><?php echo e($meja->ID_MEJA); ?></h5>
                                    <span class="badge <?php echo e($terisi ? 'bg-danger' : 'bg-success'); ?> bg-opacity-10 text-<?php echo e($terisi ? 'danger' : 'success'); ?> rounded-pill px-3 py-1 fw-bold" style="font-size: 0.75rem;">
                                        <?php echo e($terisi ? 'Terisi' : 'Tersedia'); ?>

                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="row g-4">
                    <div class="col-lg-7">
                        <div class="card-modern mb-4">
                            <div class="card-header-modern bg-white">
                                <h6 class="card-title-modern text-danger"><i class="bi bi-wallet2"></i> Menunggu Pembayaran</h6>
                                <?php if(count($menungguBayar) > 0): ?> <span class="badge bg-danger rounded-pill px-3 py-2"><?php echo e(count($menungguBayar)); ?> Pesanan</span> <?php endif; ?>
                            </div>
                            <div class="table-scroll-container border-0 rounded-0" style="max-height: 350px;">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light"><tr><th>ID</th><th>Meja</th><th class="text-end">Total</th><th class="text-center">Aksi</th></tr></thead>
                                    <tbody id="list-menunggu-bayar">
                                        <?php $__empty_1 = true; $__currentLoopData = $menungguBayar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr id="row-bayar-<?php echo e($p->ID_PESANAN); ?>">
                                            <td class="fw-bold text-primary">#<?php echo e($p->ID_PESANAN); ?></td>
                                            <td><span class="badge bg-dark rounded-pill px-3 py-1">Meja <?php echo e($p->ID_MEJA); ?></span></td>
                                            <td class="fw-bold text-end fs-6">Rp <?php echo e(number_format($p->TOTAL_BAYAR, 0, ',', '.')); ?></td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-success btn-modern text-white rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#modalBayar<?php echo e($p->ID_PESANAN); ?>">
                                                    <i class="bi bi-check-lg me-1"></i> Proses
                                                </button>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr><td colspan="4" class="text-center py-5 text-muted small"><i class="bi bi-wallet2 fs-1 d-block mb-3 opacity-25"></i>Tidak ada antrean bayar</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-modern">
                            <div class="card-header-modern bg-white">
                                <h6 class="card-title-modern text-primary"><i class="bi bi-fire"></i> Sedang Dimasak</h6>
                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2"><?php echo e(count($sedangProses)); ?> Aktif</span>
                            </div>
                            <div class="table-scroll-container border-0 rounded-0">
                                <table class="table table-hover align-middle mb-0">
                                    <thead><tr><th>ID</th><th>Meja</th><th>Status</th><th>Aksi</th></tr></thead>
                                    <tbody id="list-sedang-proses">
                                        <?php $__empty_1 = true; $__currentLoopData = $sedangProses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr id="row-proses-<?php echo e($p->ID_PESANAN); ?>">
                                            <td class="fw-bold">#<?php echo e($p->ID_PESANAN); ?></td>
                                            <td><span class="badge bg-dark rounded-pill px-3 py-1">Meja <?php echo e($p->ID_MEJA); ?></span></td>
                                            <td id="status-badge-<?php echo e($p->ID_PESANAN); ?>">
                                                <?php if($p->STATUS_PESANAN == 'Proses'): ?> <span class="badge bg-warning text-dark rounded-pill px-3 py-1">Antre</span>
                                                <?php elseif($p->STATUS_PESANAN == 'Dimasak'): ?> <span class="badge bg-info rounded-pill px-3 py-1">Masak</span>
                                                <?php elseif($p->STATUS_PESANAN == 'Siap'): ?> <span class="badge bg-success rounded-pill px-3 py-1">Siap</span> <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2 align-items-center justify-content-end">
                                                    <form action="<?php echo e(route('pesanan.updateStatus', $p->ID_PESANAN)); ?>" method="POST" class="ajax-form-status" data-id="<?php echo e($p->ID_PESANAN); ?>">
                                                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                                        <?php if($p->STATUS_PESANAN == 'Proses'): ?> <button type="submit" class="btn btn-sm btn-outline-warning rounded-pill btn-action px-3"><i class="bi bi-play-fill me-1"></i> Masak</button>
                                                        <?php elseif($p->STATUS_PESANAN == 'Dimasak'): ?> <button type="submit" class="btn btn-sm btn-outline-info rounded-pill btn-action px-3"><i class="bi bi-bell-fill me-1"></i> Panggil</button>
                                                        <?php elseif($p->STATUS_PESANAN == 'Siap'): ?> <button type="submit" class="btn btn-sm btn-outline-success rounded-pill btn-action px-3"><i class="bi bi-check-all me-1"></i> Selesai</button> <?php endif; ?>
                                                    </form>
                                                    <button class="btn btn-sm btn-light border rounded-circle shadow-sm" data-bs-toggle="modal" data-bs-target="#detailPesanan<?php echo e($p->ID_PESANAN); ?>" title="Lihat Detail"><i class="bi bi-eye"></i></button>
                                                    
                                                    <a href="<?php echo e(route('cetak.dapur', $p->ID_PESANAN)); ?>" target="_blank" class="btn btn-sm btn-dark rounded-circle text-white shadow-sm" title="Cetak Bon Dapur">
                                                        <i class="bi bi-printer-fill"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr><td colspan="4" class="text-center py-5 text-muted small"><i class="bi bi-cup-hot fs-1 d-block mb-3 opacity-25"></i>Dapur sedang santai.</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="card-modern h-100 d-flex flex-column">
                            <div class="card-header-modern bg-white">
                                <h6 class="card-title-modern text-success"><i class="bi bi-clock-history"></i> Riwayat Selesai</h6>
                                <div class="d-flex gap-2">
                                    <form action="<?php echo e(route('kasir.dashboard')); ?>" method="GET" class="d-flex align-items-center">
                                        <div class="input-group input-group-sm shadow-sm rounded-pill overflow-hidden">
                                            <span class="input-group-text bg-light border-0 ps-3"><i class="bi bi-calendar3"></i></span>
                                            <input type="date" name="tanggal" class="form-control border-0 bg-light pe-3" value="<?php echo e($tanggalFilter); ?>" onchange="this.form.submit()">
                                        </div>
                                    </form>
                                    <a href="<?php echo e(route('kasir.export', ['tanggal' => $tanggalFilter])); ?>" class="btn btn-sm btn-success rounded-pill shadow-sm d-flex align-items-center px-3" title="Download Excel">
                                        <i class="bi bi-file-earmark-spreadsheet me-2"></i> Excel
                                    </a>
                                </div>
                            </div>
                            <div class="table-scroll-container border-0 rounded-0 flex-grow-1" style="max-height: 500px;">
                                <table class="table table-hover align-middle mb-0 text-center">
                                    <thead><tr><th>Jam</th><th>ID</th><th>Total</th><th>Aksi</th></tr></thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $riwayatSelesai; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td class="small text-muted"><?php echo e($p->pembayaran ? \Carbon\Carbon::parse($p->pembayaran->WAKTU_PEMBAYARAN)->setTimezone('Asia/Jakarta')->format('H:i') : '-'); ?></td>
                                            <td class="fw-bold small">#<?php echo e($p->ID_PESANAN); ?></td>
                                            <td class="fw-bold text-success small">Rp <?php echo e(number_format($p->TOTAL_BAYAR/1000, 0)); ?>k</td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                    <button class="btn btn-sm btn-light rounded-circle border shadow-sm" data-bs-toggle="modal" data-bs-target="#detailPesanan<?php echo e($p->ID_PESANAN); ?>" title="Lihat Detail"><i class="bi bi-eye"></i></button>
                                                    <a href="<?php echo e(route('cetak.struk', $p->ID_PESANAN)); ?>" target="_blank" class="btn btn-sm btn-dark rounded-circle text-white shadow-sm" title="Cetak Struk"><i class="bi bi-printer-fill"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr><td colspan="4" class="text-center py-5 text-muted small"><i class="bi bi-clock-history fs-1 d-block mb-3 opacity-25"></i>Belum ada data.</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="p-3 border-top bg-white mt-auto">
                                <div class="d-flex justify-content-between align-items-center bg-success-subtle p-4 rounded-4 shadow-sm border border-success-subtle">
                                    <div>
                                        <small class="text-success fw-bold text-uppercase d-block mb-1" style="font-size: 0.75rem; letter-spacing: 1px;">TOTAL OMSET HARI INI</small>
                                        <div class="badge bg-success rounded-pill px-3 py-1 fs-6"><i class="bi bi-calendar-check me-2"></i> <?php echo e(\Carbon\Carbon::parse($tanggalFilter)->format('d M Y')); ?></div>
                                    </div>
                                    <h2 class="fw-extrabold text-success mb-0 tracking-tight fs-3">Rp <?php echo e(number_format($riwayatSelesai->sum('TOTAL_BAYAR'), 0, ',', '.')); ?></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="nav-menu">
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <div>
                        <h1 class="fw-bold mb-2" style="color: var(--text-dark);">Daftar Menu</h1>
                        <p class="text-muted mb-0 fs-5">Kelola ketersediaan dan informasi menu restoran.</p>
                    </div>
                    <button class="btn btn-primary btn-modern rounded-pill shadow-lg px-4 py-2 fs-6" data-bs-toggle="modal" data-bs-target="#modalTambahMenu">
                        <i class="bi bi-plus-lg me-2"></i> Tambah Menu
                    </button>
                </div>

                <div class="bg-white p-2 rounded-pill shadow-sm d-inline-flex mb-5 border">
                    <ul class="nav nav-pills" id="pills-tab">
                        <li class="nav-item"><button class="nav-link active rounded-pill px-4 fw-bold" id="tab-makanan" data-bs-toggle="pill" data-bs-target="#makanan">Makanan</button></li>
                        <li class="nav-item"><button class="nav-link rounded-pill px-4 fw-bold" id="tab-minuman" data-bs-toggle="pill" data-bs-target="#minuman">Minuman</button></li>
                        <li class="nav-item"><button class="nav-link rounded-pill px-4 fw-bold" id="tab-snack" data-bs-toggle="pill" data-bs-target="#snack">Snack</button></li>
                    </ul>
                </div>

                <div class="card-modern">
                    <div class="card-header-modern bg-white">
                         <h6 class="card-title-modern text-dark"><i class="bi bi-list-ul"></i> Daftar Semua Menu</h6>
                    </div>
                    <div class="tab-content p-3">
                        <?php $cats = ['makanan' => 'K01', 'minuman' => 'K02', 'snack' => 'K03']; ?>
                        <?php $__currentLoopData = $cats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tabId => $catId): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="tab-pane fade <?php echo e($loop->first ? 'show active' : ''); ?>" id="<?php echo e($tabId); ?>">
                            <table class="table table-hover align-middle mb-0">
                                <thead><tr><th class="ps-4">Item</th><th>Harga</th><th>Status</th><th class="text-end pe-4">Aksi</th></tr></thead>
                                <tbody>
                                    <?php $__currentLoopData = $daftarMenu->where('ID_KATEGORI', $catId); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center gap-3">
                                                <?php if($m->FOTO): ?> <img src="/images/menu/<?php echo e($m->FOTO); ?>" class="img-menu shadow-sm"> <?php else: ?> <div class="img-menu bg-light d-flex align-items-center justify-content-center small text-muted shadow-sm">No IMG</div> <?php endif; ?>
                                                <span class="fw-bold fs-6"><?php echo e($m->NAMA_MENU); ?></span>
                                            </div>
                                        </td>
                                        <td class="fs-6">Rp <?php echo e(number_format($m->HARGA_SATUAN, 0, ',', '.')); ?></td>
                                        <td>
                                            <form action="<?php echo e(route('menu.status', $m->ID_MENU)); ?>" method="POST" class="ajax-form-menu">
                                                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                                <button type="submit" class="badge border-0 <?php echo e($m->STATUS_TESEDIA == 'tersedia' ? 'bg-success' : 'bg-secondary'); ?> rounded-pill px-3 py-2 fw-bold btn-status-menu">
                                                    <?php echo e(ucfirst($m->STATUS_TESEDIA)); ?>

                                                </button>
                                            </form>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="d-flex justify-content-end gap-2">
                                                <button class="btn btn-sm btn-light border rounded-pill px-3 fw-bold text-muted shadow-sm" data-bs-toggle="modal" data-bs-target="#editMenu<?php echo e($m->ID_MENU); ?>">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </button>
                                                <button class="btn btn-sm btn-danger bg-opacity-10 text-danger border-0 rounded-circle shadow-sm" data-bs-toggle="modal" data-bs-target="#hapusMenu<?php echo e($m->ID_MENU); ?>">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="editMenu<?php echo e($m->ID_MENU); ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content shadow-lg border-0">
                                                <div class="modal-header border-0 pb-0">
                                                    <h5 class="modal-title fw-bold">Edit Menu</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="<?php echo e(route('menu.update', $m->ID_MENU)); ?>" method="POST" enctype="multipart/form-data">
                                                    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                                    <div class="modal-body">
                                                        <div class="mb-3 text-center">
                                                            <?php if($m->FOTO): ?> <img src="/images/menu/<?php echo e($m->FOTO); ?>" class="rounded-3 shadow-sm mb-2" style="width: 100px; height: 100px; object-fit: cover;"> <?php endif; ?>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label small fw-bold">Nama Menu</label>
                                                            <input type="text" name="NAMA_MENU" class="form-control" value="<?php echo e($m->NAMA_MENU); ?>" required>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-6 mb-3">
                                                                <label class="form-label small fw-bold">Harga</label>
                                                                <input type="number" name="HARGA_SATUAN" class="form-control" value="<?php echo e($m->HARGA_SATUAN); ?>" required>
                                                            </div>
                                                            <div class="col-6 mb-3">
                                                                <label class="form-label small fw-bold">Kategori</label>
                                                                <select name="ID_KATEGORI" class="form-select">
                                                                    <option value="K01" <?php echo e($m->ID_KATEGORI == 'K01' ? 'selected' : ''); ?>>Makanan</option>
                                                                    <option value="K02" <?php echo e($m->ID_KATEGORI == 'K02' ? 'selected' : ''); ?>>Minuman</option>
                                                                    <option value="K03" <?php echo e($m->ID_KATEGORI == 'K03' ? 'selected' : ''); ?>>Snack</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label small fw-bold">Ganti Foto (Opsional)</label>
                                                            <input type="file" name="FOTO" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer border-0 pt-0">
                                                        <button type="submit" class="btn btn-primary w-100 rounded-pill">Simpan Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="hapusMenu<?php echo e($m->ID_MENU); ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-sm modal-dialog-centered">
                                            <div class="modal-content shadow-lg border-0">
                                                <div class="modal-body text-center p-4">
                                                    <div class="text-danger mb-3"><i class="bi bi-exclamation-circle" style="font-size: 3rem;"></i></div>
                                                    <h5 class="fw-bold mb-2">Hapus Menu?</h5>
                                                    <p class="text-muted small">Menu <b><?php echo e($m->NAMA_MENU); ?></b> akan dihapus permanen.</p>
                                                    <form action="<?php echo e(route('menu.destroy', $m->ID_MENU)); ?>" method="POST">
                                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="btn btn-danger w-100 rounded-pill mb-2">Ya, Hapus</button>
                                                        <button type="button" class="btn btn-light w-100 rounded-pill" data-bs-dismiss="modal">Batal</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="modalTambahMeja" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content shadow-lg">
                <form action="<?php echo e(route('meja.store')); ?>" method="POST"><?php echo csrf_field(); ?>
                    <div class="modal-header border-0"><h5 class="modal-title fw-bold">Meja Baru</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                    <div class="modal-body">
                        <input type="text" name="ID_MEJA" class="form-control form-control-lg bg-light border-0 rounded-3 text-center fw-bold" placeholder="Cth: A8" required>
                    </div>
                    <div class="modal-footer border-0 pt-0"><button type="submit" class="btn btn-primary w-100 rounded-pill btn-modern">Simpan</button></div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTambahMenu" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Tambah Menu Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?php echo e(route('menu.store')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nama Menu</label>
                            <input type="text" name="NAMA_MENU" class="form-control" placeholder="Contoh: Kopi Susu" required>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label small fw-bold">Harga (Rp)</label>
                                <input type="number" name="HARGA_SATUAN" class="form-control" placeholder="15000" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label small fw-bold">Kategori</label>
                                <select name="ID_KATEGORI" class="form-select" required>
                                    <option value="K01">Makanan</option>
                                    <option value="K02">Minuman</option>
                                    <option value="K03">Snack</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Foto Menu</label>
                            <input type="file" name="FOTO" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="submit" class="btn btn-primary w-100 rounded-pill">Simpan Menu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php $semuaPesanan = $menungguBayar->merge($sedangProses)->merge($riwayatSelesai); ?>
    <?php $__currentLoopData = $semuaPesanan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="modal fade" id="detailPesanan<?php echo e($p->ID_PESANAN); ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content shadow-lg overflow-hidden">
                    <div class="modal-header bg-light border-0 py-3 px-4">
                        <div><h5 class="modal-title fw-bold fs-5">Pesanan #<?php echo e($p->ID_PESANAN); ?></h5><small class="text-muted fs-6">Meja <?php echo e($p->ID_MEJA); ?></small></div>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-0">
                        <table class="table table-striped mb-0">
                            <tbody>
                                <?php $__currentLoopData = $p->detail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <?php if($item->menu && $item->menu->FOTO): ?> <img src="/images/menu/<?php echo e($item->menu->FOTO); ?>" class="img-menu shadow-sm" style="width: 40px; height: 40px;"> <?php else: ?> <div class="img-menu bg-light d-flex align-items-center justify-content-center small text-muted shadow-sm" style="width: 40px; height: 40px;">No IMG</div> <?php endif; ?>
                                            <span class="fw-bold"><?php echo e($item->menu ? $item->menu->NAMA_MENU : 'Menu Dihapus'); ?></span>
                                        </div>
                                    </td>
                                    <td class="text-center fw-bold py-3">x<?php echo e($item->QTY); ?></td>
                                    <td class="text-end pe-4 py-3 fw-bold">Rp <?php echo e(number_format($item->SUBTOTAL, 0, ',', '.')); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            <tfoot class="bg-white"><tr><td colspan="2" class="ps-4 py-3 fw-bold fs-5">TOTAL BAYAR</td><td class="text-end pe-4 py-3 fw-bold text-primary fs-4">Rp <?php echo e(number_format($p->TOTAL_BAYAR, 0, ',', '.')); ?></td></tr></tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalBayar<?php echo e($p->ID_PESANAN); ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content shadow-lg border-0">
                    <div class="modal-header bg-success text-white border-0 justify-content-center py-3"><h5 class="modal-title fw-bold">Konfirmasi Bayar</h5></div>
                    <form action="<?php echo e(route('pesanan.bayar', $p->ID_PESANAN)); ?>" method="POST" class="ajax-form-bayar" data-id="<?php echo e($p->ID_PESANAN); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="modal-body text-center p-4">
                            <h2 class="fw-bold text-dark mb-1 fs-2">Rp <?php echo e(number_format($p->TOTAL_BAYAR, 0, ',', '.')); ?></h2>
                            <p class="text-muted small mb-4 fs-6">ID Pesanan: #<?php echo e($p->ID_PESANAN); ?></p>
                            <div class="text-start">
                                <label class="fw-bold small mb-2 text-secondary fs-6">Metode Pembayaran</label>
                                <select name="id_metode" class="form-select form-select-lg bg-light border-0 rounded-3 fs-6 shadow-sm" required>
                                    <option value="">Pilih Metode...</option>
                                    <?php $__currentLoopData = $metodeBayar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($mb->ID_METODE); ?>"><?php echo e($mb->NAMA_METODE); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="p-4 pt-0"><button type="submit" class="btn btn-success w-100 rounded-pill btn-modern py-2 fs-6 shadow-sm">Terima Pembayaran</button></div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            
            // --- NOTIFIKASI SUKSES / GAGAL ---
            <?php if(session('success')): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '<?php echo e(session('success')); ?>',
                    timer: 2000,
                    showConfirmButton: false
                });
            <?php endif; ?>

            <?php if(session('error')): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Ops!',
                    text: '<?php echo e(session('error')); ?>',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Oke, Saya Paham'
                });
            <?php endif; ?>

            // Logic Tab
            let lastMainTab = localStorage.getItem('lastMainTab') || 'nav-pos-tab';
            let mainTabElement = document.querySelector(`#${lastMainTab}`);
            if(mainTabElement) new bootstrap.Tab(mainTabElement).show();

            document.querySelectorAll('.nav-sidebar .nav-link').forEach(btn => {
                btn.addEventListener('shown.bs.tab', e => localStorage.setItem('lastMainTab', e.target.id));
            });

            // ============================================================
            // 3. FUNGSI PENGIKAT TOMBOL (AGAR TOMBOL TETAP JALAN SETELAH AUTO-REFRESH)
            // ============================================================
            function bindActions() {
                // A. LOGIC TOMBOL BAYAR (AJAX)
                document.querySelectorAll('.ajax-form-bayar').forEach(form => {
                    // Hapus listener lama (kloning) biar gak double klik
                    let newForm = form.cloneNode(true);
                    form.parentNode.replaceChild(newForm, form);

                    newForm.addEventListener('submit', function(e) {
                        e.preventDefault();
                        let btn = this.querySelector('button[type="submit"]');
                        let originalText = btn.innerHTML;
                        btn.innerHTML = 'Loading...'; btn.disabled = true;
                        let id = this.getAttribute('data-id');
                        let modalEl = document.getElementById(`modalBayar${id}`);
                        let modal = bootstrap.Modal.getInstance(modalEl);
                        
                        if(!modal) modal = new bootstrap.Modal(modalEl);

                        fetch(this.action, {
                            method: 'POST',
                            body: new FormData(this),
                            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                        })
                        .then(res => {
                            if(res.ok) {
                                modal.hide();
                                Swal.fire({icon: 'success', title: 'Pembayaran Berhasil!', timer: 1000, showConfirmButton: false});
                                loadDashboardData(); // Update data langsung tanpa refresh
                            }
                        })
                        .catch(err => { console.error(err); btn.innerHTML = originalText; btn.disabled = false; });
                    });
                });

                // B. LOGIC TOMBOL STATUS (MASAK / SELESAI)
                document.querySelectorAll('.ajax-form-status').forEach(form => {
                    let newForm = form.cloneNode(true);
                    form.parentNode.replaceChild(newForm, form);

                    newForm.addEventListener('submit', function(e) {
                        e.preventDefault();
                        let btn = this.querySelector('button');
                        // Efek Loading Kecil
                        let originalContent = btn.innerHTML;
                        btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
                        
                        fetch(this.action, {
                            method: 'POST',
                            body: new FormData(this),
                            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                        })
                        .then(res => {
                            if(res.ok) {
                                // Jika sukses, langsung refresh data tabelnya saja
                                loadDashboardData(); 
                                // Opsional: Kasih notif kecil
                                const Toast = Swal.mixin({toast: true, position: 'top-end', showConfirmButton: false, timer: 1000});
                                Toast.fire({icon: 'success', title: 'Status Diperbarui'});
                            }
                        });
                    });
                });
            }

            // ============================================================
            // 4. ENGINE AUTO-REFRESH (JANTUNGNYA DISINI)
            // ============================================================
            function loadDashboardData() {
                // Hanya refresh kalau sedang di Tab "Monitor Pesanan"
                if(!document.querySelector('#nav-pos').classList.contains('active')) return;

                fetch(window.location.href)
                .then(response => response.text())
                .then(html => {
                    let parser = new DOMParser();
                    let doc = parser.parseFromString(html, 'text/html');

                    // Update Tabel Menunggu Bayar
                    let newTabelBayar = doc.getElementById('list-menunggu-bayar').innerHTML;
                    if(document.getElementById('list-menunggu-bayar').innerHTML !== newTabelBayar) {
                        document.getElementById('list-menunggu-bayar').innerHTML = newTabelBayar;
                        bindActions(); // Pasang ulang fungsi tombol
                    }

                    // Update Tabel Sedang Dimasak
                    let newTabelProses = doc.getElementById('list-sedang-proses').innerHTML;
                    if(document.getElementById('list-sedang-proses').innerHTML !== newTabelProses) {
                        document.getElementById('list-sedang-proses').innerHTML = newTabelProses;
                        bindActions(); // Pasang ulang fungsi tombol
                    }

                    // Update Angka Statistik (Total & Omset)
                    let newStats = doc.querySelector('.row.mb-5.g-4').innerHTML;
                    if(document.querySelector('.row.mb-5.g-4').innerHTML !== newStats) {
                        document.querySelector('.row.mb-5.g-4').innerHTML = newStats;
                    }

                    // Update Status Meja (Kotak-kotak meja)
                    let newMeja = doc.querySelector('.row.mb-5.g-3').innerHTML;
                    if(document.querySelector('.row.mb-5.g-3').innerHTML !== newMeja) {
                        document.querySelector('.row.mb-5.g-3').innerHTML = newMeja;
                    }

                    // Update Riwayat Selesai
                    let newRiwayat = doc.querySelector('#nav-pos .col-lg-5 .table tbody').innerHTML;
                    if(document.querySelector('#nav-pos .col-lg-5 .table tbody').innerHTML !== newRiwayat) {
                        document.querySelector('#nav-pos .col-lg-5 .table tbody').innerHTML = newRiwayat;
                    }
                })
                .catch(err => console.log('Silent refresh skip...'));
            }

            // Jalankan fungsi pengikat tombol pertama kali
            bindActions();

            // Jalankan Auto-Refresh setiap 3 Detik
            setInterval(loadDashboardData, 3000); 

            // Logic Menu (Terpisah karena jarang berubah)
            document.querySelectorAll('.ajax-form-menu').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    let btn = this.querySelector('.btn-status-menu');
                    fetch(this.action, { method: 'POST', body: new FormData(this), headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content } })
                    .then(res => { if(res.ok) { 
                        if(btn.classList.contains('bg-success')) { btn.classList.replace('bg-success', 'bg-secondary'); btn.innerText = 'Habis'; }
                        else { btn.classList.replace('bg-secondary', 'bg-success'); btn.innerText = 'Tersedia'; }
                    }});
                });
            });

        });
    </script>
</body>
</html><?php /**PATH C:\xampp\htdocs\riels\riels\resources\views/kasir/dashboard.blade.php ENDPATH**/ ?>