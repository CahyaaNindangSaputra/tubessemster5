<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DAPUR - Meja {{ $order->ID_MEJA }}</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
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
            margin-top: 3px;
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
        <p style="margin:5px 0;">{{ \Carbon\Carbon::parse($order->created_at)->setTimezone('Asia/Jakarta')->format('d/m/Y H:i') }}</p>
    </div>

    <div class="line"></div>

    <div class="text-center">
        <span style="font-size: 14px;">MEJA</span>
        <span class="big">{{ $order->ID_MEJA }}</span>
    </div>

    <div class="line"></div>

    <div>
        @foreach($order->detail as $item)
        <div class="item-container">
            <div class="qty-box">{{ $item->QTY }}</div>
            
            <div class="menu-name">
                {{ $item->menu->NAMA_MENU ?? 'Menu Dihapus' }}
            </div>
        </div>
        @endforeach
    </div>

    <div class="line"></div>

    <div class="text-center bold">
        <p style="margin-bottom: 5px;">ORDER ID: #{{ $order->ID_PESANAN }}</p>
        <p style="font-size: 12px;">*** SEGERA PROSES ***</p>
    </div>

    <button class="no-print" onclick="window.print()" style="width: 100%; padding: 12px; margin-top: 20px; font-weight: bold; cursor: pointer; background: black; color: white; border: none; border-radius: 8px;">
        🖨️ Cetak Struk Dapur
    </button>

</body>
</html>