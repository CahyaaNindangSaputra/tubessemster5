<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DAPUR - Meja <?php echo e($order->ID_MEJA); ?></title>
    <link rel="icon" href="<?php echo e(asset('images/logo.png')); ?>" type="image/x-icon">
    <style>
        body { 
            font-family: 'Courier New', monospace; 
            font-size: 14px; 
            max-width: 300px; 
            margin: 0 auto; 
            padding: 15px; 
            color: #000; 
            background: #fff; 
        }
        .text-center { text-align: center; }
        .bold { font-weight: bold; }
        .big { font-size: 32px; font-weight: 900; display: block; margin: 5px 0; }
        .line { border-bottom: 2px dashed #000; margin: 15px 0; }
        
        /* Tampilan Item + QTY */
        .item-container {
            display: flex;
            align-items: flex-start;
            margin-bottom: 12px;
        }
        .qty-box {
            border: 2px solid #000;
            padding: 4px 8px;
            font-weight: 900;
            font-size: 18px;
            min-width: 30px;
            text-align: center;
            margin-right: 10px;
            border-radius: 4px;
        }
        .menu-name {
            font-size: 16px;
            font-weight: bold;
            margin-top: 3px; /* Biar sejajar sama kotak */
            line-height: 1.2;
        }

        @media print {
            @page { margin: 0; size: auto; }
            body { margin: 0; padding: 10px; }
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="text-center">
        <h3 style="margin:0; text-transform: uppercase;">ORDER DAPUR</h3>
        <p style="margin:5px 0;"><?php echo e(date('d/m/Y H:i', strtotime($order->created_at))); ?></p>
    </div>

    <div class="line"></div>

    <div class="text-center">
        <span style="font-size: 14px;">MEJA</span>
        <span class="big"><?php echo e($order->ID_MEJA); ?></span>
    </div>

    <div class="line"></div>

    <div>
        <?php $__currentLoopData = $order->detail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="item-container">
            <div class="qty-box"><?php echo e($item->QTY); ?></div>
            
            <div class="menu-name">
                <?php echo e($item->menu->NAMA_MENU ?? 'Menu Dihapus'); ?>

            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="line"></div>

    <div class="text-center bold">
        <p style="margin-bottom: 5px;">ORDER ID: #<?php echo e($order->ID_PESANAN); ?></p>
        <p style="font-size: 12px;">*** SEGERA PROSES ***</p>
    </div>

    <button class="no-print" onclick="window.print()" style="width: 100%; padding: 12px; margin-top: 20px; font-weight: bold; cursor: pointer; background: black; color: white; border: none; border-radius: 8px;">
        🖨️ Cetak Struk Dapur
    </button>

</body>
</html><?php /**PATH C:\xampp\htdocs\riels\riels\resources\views/kasir/struk_dapur.blade.php ENDPATH**/ ?>