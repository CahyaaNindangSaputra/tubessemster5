<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>"> 
    <title>Menu Riels Coffee - Meja <?php echo e(session('customer_meja')); ?></title>
    
    <link rel="icon" href="<?php echo e(asset('images/logo.png')); ?>" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        :root { --primary-dark: #1a1a1a; --accent-blue: #0d6efd; }
        body { background-color: #f4f7f6; font-family: 'Plus Jakarta Sans', sans-serif; color: #333; padding-bottom: 80px; }
        
        /* Navbar Glassmorphism */
        .navbar-custom { background: rgba(33, 37, 41, 0.95); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(255,255,255,0.1); }

        /* Banner Welcome */
        .welcome-banner { background: linear-gradient(45deg, #1a1a1a, #2c3e50); color: white; border-radius: 20px; padding: 20px; margin-bottom: 20px; box-shadow: 0 10px 20px rgba(0,0,0,0.1); }

        /* Search Bar */
        .search-container { position: relative; margin-bottom: 20px; }
        .search-input { width: 100%; border: none; padding: 15px 20px 15px 50px; border-radius: 50px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); transition: 0.3s; }
        .search-input:focus { outline: none; box-shadow: 0 5px 20px rgba(13, 110, 253, 0.2); }
        .search-icon { position: absolute; left: 20px; top: 50%; transform: translateY(-50%); color: #aaa; }

        /* --- BUBBLE NAVIGATION STYLE --- */
        .nav-pills-container { display: flex; justify-content: center; margin-bottom: 1.5rem; }
        .nav-pills-custom { position: relative; display: inline-flex; background-color: #fff; border-radius: 50px; padding: 5px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .nav-link-custom { position: relative; z-index: 2; color: #6c757d; border: none; background: transparent; padding: 10px 25px; font-weight: 600; border-radius: 50px; transition: color 0.3s ease; }
        .nav-link-custom.active { color: #fff !important; background-color: transparent !important; }
        .glider { position: absolute; top: 5px; left: 5px; height: calc(100% - 10px); background-color: var(--primary-dark); border-radius: 50px; z-index: 1; transition: 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55); }

        /* Menu Card */
        .menu-card { border: none; border-radius: 20px; transition: 0.4s; background: #fff; overflow: hidden; position: relative; height: 100%; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        .menu-card:active { transform: scale(0.98); } 
        .menu-card.stok-habis { opacity: 0.6; filter: grayscale(1); pointer-events: none; }
        
        .img-container { width: 100%; aspect-ratio: 1 / 1; overflow: hidden; background: #f8f9fa; position: relative; }
        .img-container img { width: 100%; height: 100%; object-fit: cover; transition: 0.5s; }

        /* Floating Buttons */
        .floating-history { position: fixed; bottom: 25px; left: 20px; z-index: 1000; border-radius: 50px; padding: 12px 20px; font-weight: 700; box-shadow: 0 10px 25px rgba(0,0,0,0.2); border: none; font-size: 0.9rem; }
        .floating-cart { position: fixed; bottom: 25px; right: 20px; z-index: 1000; border-radius: 50px; padding: 12px 25px; font-weight: 700; box-shadow: 0 10px 25px rgba(13, 110, 253, 0.3); border: none; text-decoration: none; font-size: 0.9rem; transition: transform 0.2s; }
        .cart-bump { transform: scale(1.2); } 

        .modal-body::-webkit-scrollbar { width: 4px; }
        .modal-body::-webkit-scrollbar-thumb { background: #dee2e6; border-radius: 10px; }
        
        @media (max-width: 576px) {
            .navbar-brand { font-size: 1.1rem; }
            .welcome-banner { padding: 15px; }
            .menu-card .card-body { padding: 12px; }
            h6.fw-bold { font-size: 0.95rem; }
            p.small { font-size: 0.8rem; }
        }

        /* BUTTON GIVEAWAY */
        .btn-giveaway { position: fixed; bottom: 90px; right: 20px; width: 60px; height: 60px; background: linear-gradient(45deg, #f59e0b, #d97706); color: white; border-radius: 50%; border: none; box-shadow: 0 4px 15px rgba(245, 158, 11, 0.5); z-index: 1050; display: flex; align-items: center; justify-content: center; font-size: 24px; cursor: pointer; animation: bounce-gift 2s infinite; transition: transform 0.3s; }
        .btn-giveaway:hover { transform: scale(1.1); }
        @keyframes bounce-gift { 0%, 100% { transform: translateY(0) rotate(0); } 50% { transform: translateY(-10px) rotate(-5deg); } 75% { transform: translateY(-5px) rotate(5deg); } }
        .modal-giveaway-header { background: linear-gradient(135deg, #4361ee 0%, #3f37c9 100%); color: white; border-bottom: 0; border-radius: 20px 20px 0 0; text-align: center; padding: 30px 20px; }
        .gift-icon-big { font-size: 80px; margin-bottom: 10px; text-shadow: 0 5px 15px rgba(0,0,0,0.2); animation: shake 1s infinite; }
        @keyframes shake { 0% { transform: rotate(0deg); } 25% { transform: rotate(-10deg); } 75% { transform: rotate(10deg); } 100% { transform: rotate(0deg); } }
        
        /* STATUS BADGE */
        .badge-status { font-size: 0.75rem; padding: 5px 10px; border-radius: 50px; }
        .status-Menunggu { background: #fff3cd; color: #856404; }
        .status-Proses { background: #cff4fc; color: #055160; }
        .status-Dimasak { background: #d1e7dd; color: #0f5132; }
        .status-Siap { background: #d1e7dd; color: #198754; font-weight: bold; }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark navbar-custom sticky-top py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <span class="navbar-brand fw-bold tracking-tight"><i class="bi bi-cup-hot-fill me-2"></i>RIELS COFFEE</span>
            <span class="badge bg-white text-dark rounded-pill px-3 py-2 fw-bold shadow-sm d-flex align-items-center">
                <i class="bi bi-geo-alt-fill text-danger me-1"></i> Meja <?php echo e(session('customer_meja')); ?> 
                <?php if(session('customer_nama')): ?>
                    <span class="text-muted mx-2">|</span> <i class="bi bi-person-circle text-primary me-1"></i> <?php echo e(session('customer_nama')); ?>

                    <a href="<?php echo e(route('customer.logout')); ?>" id="btn-reset" class="btn btn-danger btn-sm rounded-circle ms-2 d-flex align-items-center justify-content-center p-0 shadow-sm" style="width: 20px; height: 20px; text-decoration: none;"> <i class="bi bi-x small text-white"></i> </a>
                <?php endif; ?>
            </span>
        </div>
    </nav>

    <div class="container py-3 mb-5">
        <?php if(session('success') && !str_contains(session('success'), 'berhasil ditambahkan')): ?>
            <div class="alert alert-success alert-dismissible fade show rounded-4 text-center mb-4 border-0 shadow-sm py-3" role="alert">
                <i class="bi bi-check-circle-fill fs-1 d-block mb-2 text-success"></i>
                <h5 class="fw-bold">Pesanan Diterima!</h5>
                <p class="mb-0 small"><?php echo e(session('success')); ?></p>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if(session('warning')): ?>
            <div class="alert alert-warning alert-dismissible fade show rounded-4 text-center mb-4 border-0 shadow-sm py-3" role="alert">
                <i class="bi bi-cash-coin fs-1 d-block mb-2 text-warning"></i> 
                <h5 class="fw-bold text-dark">Langkah Terakhir!</h5>
                <p class="mb-0 small text-dark fw-bold"><?php echo e(session('warning')); ?></p>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="welcome-banner d-flex justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold mb-0">Halo, <?php echo e(session('customer_nama') ?? 'Pelanggan'); ?>! 👋</h5>
                <small class="opacity-75">Mau pesan apa hari ini?</small>
            </div>
            <i class="bi bi-emoji-smile fs-1 opacity-50"></i>
        </div>

        <div class="search-container">
            <i class="bi bi-search search-icon"></i>
            <input type="text" id="cariMenu" class="search-input" placeholder="Cari menu kesukaanmu...">
        </div>

        <div class="nav-pills-container">
            <div class="nav nav-pills-custom" id="pills-tab" role="tablist">
                <div class="glider"></div> 
                <button class="nav-link nav-link-custom active" data-bs-toggle="pill" data-bs-target="#makanan" onclick="moveGlider(this)">Makanan</button>
                <button class="nav-link nav-link-custom" data-bs-toggle="pill" data-bs-target="#minuman" onclick="moveGlider(this)">Minuman</button>
                <button class="nav-link nav-link-custom" data-bs-toggle="pill" data-bs-target="#snack" onclick="moveGlider(this)">Snack</button>
            </div>
        </div>

        <div class="tab-content">
            <?php $categories = ['makanan' => 'K01', 'minuman' => 'K02', 'snack' => 'K03']; $cartCount = count((array) session('cart')); ?>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tabId => $catId): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="tab-pane fade <?php echo e($loop->first ? 'show active' : ''); ?>" id="<?php echo e($tabId); ?>">
                <div class="row g-3">
                    <?php $__empty_1 = true; $__currentLoopData = $daftarMenu->where('ID_KATEGORI', $catId); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="col-6 col-md-3 menu-item-col">
                        <div class="card menu-card h-100 <?php echo e($m->STATUS_TESEDIA == 'habis' ? 'stok-habis' : ''); ?>">
                            <div class="img-container">
                                <?php if($m->FOTO): ?> <img src="/images/menu/<?php echo e($m->FOTO); ?>" alt="<?php echo e($m->NAMA_MENU); ?>"> <?php else: ?> <div class="d-flex align-items-center justify-content-center h-100 text-muted small bg-light">No Photo</div> <?php endif; ?>
                            </div>
                            <div class="card-body pt-2 px-3 pb-3 d-flex flex-column">
                                <h6 class="fw-bold mb-1 text-truncate nama-menu" style="font-size: 0.95rem;"><?php echo e($m->NAMA_MENU); ?></h6>
                                <p class="text-primary fw-bold mb-3 small">Rp <?php echo e(number_format($m->HARGA_SATUAN, 0, ',', '.')); ?></p>
                                <div class="mt-auto">
                                    <?php if($m->STATUS_TESEDIA == 'tersedia'): ?>
                                        <form action="<?php echo e(route('cart.add', $m->ID_MENU)); ?>" method="POST" onsubmit="addToCart(event, this)">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-dark w-100 rounded-pill btn-sm py-2 fw-bold shadow-sm btn-add-cart">
                                                <i class="bi bi-plus-lg"></i> <span class="d-none d-sm-inline">Tambah</span><span class="d-inline d-sm-none">Add</span>
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <button class="btn btn-light text-muted w-100 rounded-pill btn-sm py-2 fw-bold disabled border" disabled>Habis</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-12 text-center py-5 text-muted"><i class="bi bi-emoji-frown fs-1 d-block mb-2 opacity-50"></i><small>Menu kategori ini kosong.</small></div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <button class="btn btn-dark floating-history" data-bs-toggle="modal" data-bs-target="#modalRiwayat"><i class="bi bi-receipt me-1"></i> Status</button>

    <a href="<?php echo e(route('cart.show')); ?>" class="btn btn-primary floating-cart" id="floatingCartBtn" style="<?php echo e($cartCount > 0 ? '' : 'display: none;'); ?>">
        <i class="bi bi-basket2-fill me-1"></i> <span id="cartCountBadge"><?php echo e($cartCount); ?></span> Item
    </a>

    <button class="btn-giveaway" data-bs-toggle="modal" data-bs-target="#modalGiveaway"><i class="bi bi-gift-fill"></i><span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light" style="font-size: 10px;">!</span></button>

    <div class="modal fade" id="modalGiveaway" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-dialog-centered"><div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;"><div class="modal-giveaway-header position-relative overflow-hidden"><div class="position-absolute top-0 start-0 w-100 h-100" style="opacity: 0.1; background-image: radial-gradient(#fff 2px, transparent 2px); background-size: 20px 20px;"></div><div class="gift-icon-big">🎁</div><h3 class="fw-bold mb-1">GIVEAWAY SPESIAL!</h3><p class="mb-0 text-white-50">Edisi Khusus Pelanggan Riels Coffee</p></div><div class="modal-body text-center p-4"><h5 class="fw-bold text-dark">Menangkan Grand Prize:</h5><h1 class="fw-bold text-primary mb-3" style="font-size: 2.2rem;">IPAD GEN 10</h1><img src="https://img.freepik.com/free-vector/realistic-tablet-device_23-2148192080.jpg?w=740" alt="Hadiah iPad" class="img-fluid rounded-4 shadow-sm mb-4" style="max-height: 160px;"><div class="alert alert-warning border-0 rounded-3 text-start small"><strong>📢 Cara Ikutan:</strong><ul class="mb-0 ps-3 mt-1"><li>Lakukan pemesanan minimal <strong>Rp 50.000</strong>.</li><li>Dapatkan kupon undian langsung!</li></ul></div><button class="btn btn-primary w-100 rounded-pill py-3 fw-bold shadow-lg mt-2" data-bs-dismiss="modal">SIAP, SAYA MAU PESAN! 🚀</button></div></div></div></div>

    <div class="modal fade" id="modalRiwayat" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable text-dark">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-dark text-white border-0">
                    <h6 class="modal-title fw-bold">Riwayat Pesanan Meja <?php echo e(session('customer_meja')); ?></h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body bg-light" id="riwayat-container">
                    <?php $__empty_1 = true; $__currentLoopData = $riwayatPesanan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="card border-0 shadow-sm mb-3 rounded-4 overflow-hidden">
                        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center pt-3">
                            <span class="fw-bold small">Order #<?php echo e($p->ID_PESANAN); ?></span>
                            <?php
                                $statusMap = [ 'Proses' => ['bg-secondary', 'Sedang Diproses'], 'Dimasak' => ['bg-warning text-dark', 'Sedang Dimasak'], 'Siap' => ['bg-info text-white', 'Siap Diantar'], 'Selesai' => ['bg-success', 'Selesai'] ];
                                $s = $statusMap[$p->STATUS_PESANAN] ?? ['bg-secondary', $p->STATUS_PESANAN];
                            ?>
                            <span class="badge <?php echo e($s[0]); ?> rounded-pill"><?php echo e($s[1]); ?></span>
                        </div>
                        <div class="card-body pt-0">
                            <hr class="my-2 opacity-10">
                            <?php $__currentLoopData = $p->detail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="d-flex justify-content-between small mb-1">
                                    <span><?php echo e($item->QTY); ?>x <?php echo e($item->menu->NAMA_MENU ?? 'Menu Hapus'); ?></span>
                                    <span><?php echo e(number_format($item->SUBTOTAL, 0, ',', '.')); ?></span>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <hr class="my-2 border-dashed">
                            <div class="d-flex justify-content-between fw-bold">
                                <span>Total</span>
                                <span>Rp <?php echo e(number_format($p->TOTAL_BAYAR, 0, ',', '.')); ?></span>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0 pb-3 pt-0 text-center">
                            <?php $isLunas = \DB::table('pembayaran')->where('ID_PESANAN', $p->ID_PESANAN)->exists(); ?>
                            <small class="badge <?php echo e($isLunas ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger'); ?> rounded-pill px-3">
                                <?php echo e($isLunas ? 'LUNAS' : 'BELUM BAYAR'); ?>

                            </small>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-5 opacity-50">
                        <i class="bi bi-clipboard-x fs-1"></i>
                        <p class="mt-2 small">Belum ada riwayat pesanan.</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function filterMenu(cat, btn) {
            document.querySelectorAll('.btn-cat').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            document.querySelectorAll('.menu-item-col').forEach(item => { // Fixed selector
                // Cari di dalam card apakah ada data kategori (jika pakai data attribute)
                // Atau tampilkan semua saja karena sudah di loop php per kategori di tab
            });
        }

        // =========================================================
        // SCRIPT AUTO-UPDATE STATUS PESANAN (REAL-TIME)
        // =========================================================
        document.addEventListener("DOMContentLoaded", function() {
            setInterval(function() {
                fetch(window.location.href)
                .then(response => response.text())
                .then(html => {
                    let parser = new DOMParser();
                    let doc = parser.parseFromString(html, 'text/html');
                    let newContent = doc.getElementById('riwayat-container').innerHTML;
                    let oldContent = document.getElementById('riwayat-container').innerHTML;
                    if (newContent !== oldContent) { document.getElementById('riwayat-container').innerHTML = newContent; }
                })
                .catch(err => console.log('Syncing...'));
            }, 3000);
        });

        function moveGlider(target) {
            const glider = document.querySelector('.glider');
            if(target && glider) { glider.style.width = target.offsetWidth + 'px'; glider.style.left = target.offsetLeft + 'px'; }
        }
        window.onload = function() { const activeTab = document.querySelector('.nav-link-custom.active'); moveGlider(activeTab); };

        document.getElementById('cariMenu').addEventListener('keyup', function() {
            let value = this.value.toLowerCase();
            let cards = document.querySelectorAll('.menu-item-col');
            cards.forEach(card => {
                let title = card.querySelector('.nama-menu').innerText.toLowerCase();
                card.style.display = title.includes(value) ? '' : 'none';
            });
        });

        const btnReset = document.getElementById('btn-reset');
        if (btnReset) {
            btnReset.addEventListener('click', function(e) {
                e.preventDefault(); var url = this.getAttribute('href'); 
                Swal.fire({ title: 'Ganti Pelanggan?', text: "Nama dan keranjang belanja akan dihapus/reset.", icon: 'warning', showCancelButton: true, confirmButtonColor: '#dc3545', cancelButtonColor: '#6c757d', confirmButtonText: 'Ya, Reset!' }).then((result) => { if (result.isConfirmed) { window.location.href = url; } });
            });
        }

        // ADD TO CART AJAX
        function addToCart(e, form) {
            e.preventDefault(); 
            const btn = form.querySelector('button');
            const originalContent = btn.innerHTML; 
            btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'; btn.disabled = true;

            fetch(form.action, { method: 'POST', body: new FormData(form), headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(response => {
                const cartBadge = document.getElementById('cartCountBadge');
                const cartBtn = document.getElementById('floatingCartBtn');
                let currentCount = parseInt(cartBadge.innerText);
                cartBadge.innerText = currentCount + 1;
                cartBtn.style.display = 'inline-block'; 
                cartBtn.classList.add('cart-bump');
                setTimeout(() => cartBtn.classList.remove('cart-bump'), 200);

                const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 2000, timerProgressBar: false });
                Toast.fire({ icon: 'success', title: 'Masuk Keranjang!' });

                btn.innerHTML = '<i class="bi bi-check-lg"></i> Masuk'; btn.classList.replace('btn-dark','btn-success');
                setTimeout(() => { btn.innerHTML = originalContent; btn.classList.replace('btn-success','btn-dark'); btn.disabled = false; }, 1500);
            })
            .catch(error => { console.error('Error:', error); btn.innerHTML = originalContent; btn.disabled = false; });
        }
    </script>
</body>
</html><?php /**PATH C:\xampp\htdocs\riels\riels\resources\views/customer/index.blade.php ENDPATH**/ ?>