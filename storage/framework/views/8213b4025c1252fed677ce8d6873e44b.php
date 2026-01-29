<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Pembayaran - Riels Coffee</title>
    <link rel="icon" href="<?php echo e(asset('images/logo.png')); ?>" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; font-family: 'Plus Jakarta Sans', sans-serif; }
        .payment-card { border: 2px solid #e9ecef; border-radius: 15px; transition: 0.3s; cursor: pointer; }
        .payment-card:hover, .payment-input:checked + .payment-card { border-color: #198754; background-color: #f0fff4; }
        .payment-input { display: none; } 
    </style>
</head>
<body class="d-flex align-items-center min-vh-100 py-4">

    <div class="container" style="max-width: 500px;">
        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
            <div class="card-header bg-white border-0 pt-4 px-4 text-center">
                <h4 class="fw-bold mb-0">Metode Pembayaran</h4>
                <p class="text-muted small">Pesanan #<?php echo e($order->ID_PESANAN); ?></p>
            </div>
            
            <div class="card-body p-4">
                <div class="alert alert-success text-center rounded-3 mb-4">
                    <small class="d-block text-muted">Total Tagihan</small>
                    <h2 class="fw-bold mb-0">Rp <?php echo e(number_format($order->TOTAL_BAYAR, 0, ',', '.')); ?></h2>
                </div>

                <form action="<?php echo e(route('customer.payment.confirm')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <p class="fw-bold mb-3">1. Pilih Cara Bayar:</p>
                    
                    <div class="row g-3 mb-4">
                        <?php $__currentLoopData = $metodeBayar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-6">
                            <label class="w-100 h-100">
                                <input type="radio" name="id_metode" value="<?php echo e($m->ID_METODE); ?>" class="payment-input" required>
                                <div class="payment-card p-3 text-center h-100 d-flex flex-column justify-content-center align-items-center">
                                    <i class="bi bi-wallet2 fs-3 mb-2 text-success"></i>
                                    <span class="fw-bold small"><?php echo e($m->NAMA_METODE); ?></span>
                                    <i class="bi bi-check-circle-fill text-success mt-2 d-none check-icon"></i>
                                </div>
                            </label>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <div class="card bg-light border-0 rounded-4 mb-4">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3"><i class="bi bi-person-lines-fill me-2"></i>Data Pemesan</h6>
                    
                            <?php if(session()->has('customer_nama')): ?>
                            
                                <div class="d-flex align-items-center bg-white p-3 rounded-3 border shadow-sm">
                                    <div class="bg-success-subtle text-success rounded-circle p-2 me-3">
                                        <i class="bi bi-check-lg fs-4"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block" style="font-size: 0.8rem;">Pesan Atas Nama:</small>
                                        <h5 class="fw-bold mb-0 text-dark"><?php echo e(session('customer_nama')); ?></h5>
                                        <small class="text-muted"><?php echo e(session('customer_phone')); ?></small>
                                    </div>
                                </div>
                    
                                <input type="hidden" name="nama_pelanggan" value="<?php echo e(session('customer_nama')); ?>">
                                <input type="hidden" name="nomor_hp" value="<?php echo e(session('customer_phone')); ?>">
                                
                                <div class="mt-2 text-end">
                                    <a href="<?php echo e(route('customer.logout')); ?>" class="text-danger small text-decoration-none fw-bold">
                                        <i class="bi bi-pencil-square"></i> Ganti Nama
                                    </a>
                                </div>
                    
                            <?php else: ?>
                    
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-muted">Nama Anda</label>
                                    <input type="text" name="nama_pelanggan" class="form-control form-control-lg rounded-3" placeholder="Contoh: Budi" required>
                                </div>
                    
                                <div class="mb-0">
                                    <label class="form-label small fw-bold text-muted">Nomor HP (WhatsApp)</label>
                                    <input type="number" name="nomor_hp" class="form-control form-control-lg rounded-3" placeholder="08xxxxxxxx" required>
                                </div>
                    
                            <?php endif; ?>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success w-100 rounded-pill fw-bold py-3">
                        Konfirmasi Pesanan <i class="bi bi-arrow-right ms-2"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.payment-input').forEach(input => {
            input.addEventListener('change', function() {
                document.querySelectorAll('.check-icon').forEach(i => i.classList.add('d-none'));
                document.querySelectorAll('.payment-card').forEach(c => { c.style.borderColor = '#e9ecef'; c.style.backgroundColor = 'white'; });
                
                let card = this.nextElementSibling;
                card.style.borderColor = '#198754';
                card.style.backgroundColor = '#f0fff4';
                card.querySelector('.check-icon').classList.remove('d-none');
            });
        });
    </script>

</body>
</html><?php /**PATH C:\xampp\htdocs\riels\riels\resources\views/customer/payment.blade.php ENDPATH**/ ?>