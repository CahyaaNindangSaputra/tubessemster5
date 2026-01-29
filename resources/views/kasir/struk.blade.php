<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk #{{ $order->ID_PESANAN }}</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
    <style>
        body { font-family: 'Courier New', monospace; font-size: 12px; max-width: 300px; margin: 0 auto; padding: 10px; color: #000; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }
        .line { border-bottom: 1px dashed #000; margin: 5px 0; }
        .flex { display: flex; justify-content: space-between; }
        
        @media print {
            @page { margin: 0; size: auto; }
            body { margin: 10px; }
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="text-center">
        <h2 style="margin-bottom: 5px;">RIEL'S COFFEE</h2>
        <p style="margin: 0;">Jl. Koding No. 99, Internet</p>
        <p style="margin: 0;">0812-3456-7890</p>
    </div>

    <div class="line"></div>

    <div>
        <div class="flex"><span>No Order</span> <span>#{{ $order->ID_PESANAN }}</span></div>
        <div class="flex"><span>Tanggal</span> <span>{{ date('d/m/Y H:i') }}</span></div>
        <div class="flex"><span>Pelanggan</span> <span>{{ session('customer_nama') ?? 'Umum' }}</span></div>
        <div class="flex"><span>Kasir</span> <span>Admin</span></div>
    </div>

    <div class="line"></div>

    @foreach($order->detail as $item)
    <div style="margin-bottom: 2px;">
        <div class="bold">{{ $item->menu->NAMA_MENU }}</div>
        <div class="flex">
            <span>{{ $item->QTY }} x {{ number_format($item->menu->HARGA_SATUAN, 0, ',', '.') }}</span>
            <span>{{ number_format($item->SUBTOTAL, 0, ',', '.') }}</span>
        </div>
    </div>
    @endforeach

    <div class="line"></div>

    <div class="flex bold" style="font-size: 14px; margin-top: 5px;">
        <span>TOTAL</span>
        <span>Rp {{ number_format($order->TOTAL_BAYAR, 0, ',', '.') }}</span>
    </div>
    
    <div class="flex">
        <span>Bayar ({{ $order->pembayaran->metode->NAMA_METODE ?? 'Tunai' }})</span>
        <span>LUNAS</span>
    </div>

    <div class="line"></div>

    <div class="text-center" style="margin-top: 10px;">
        <p>Terima Kasih atas Kunjungan Anda!</p>
        <p>Password Wifi: kopi_enak</p>
    </div>

    <button class="no-print" onclick="window.print()" style="width: 100%; padding: 10px; margin-top: 20px; cursor: pointer;">Cetak Struk / Simpan PDF</button>

</body>
</html>