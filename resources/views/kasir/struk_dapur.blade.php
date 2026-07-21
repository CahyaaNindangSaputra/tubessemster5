<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Dapur - #{{ $order->ID_PESANAN }}</title>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #e2e8f0;
            font-family: 'JetBrains Mono', monospace;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            color: #1e293b;
        }
        .receipt-container {
            background: #ffffff;
            width: 340px;
            padding: 25px 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .text-center { text-align: center; }
        .fw-bold { font-weight: 700; }
        .brand-title { font-size: 1.15rem; letter-spacing: 1px; margin-bottom: 2px; }
        .receipt-subtitle { font-size: 0.75rem; color: #64748b; margin-bottom: 12px; }
        .divider { border-top: 1px dashed #cbd5e1; margin: 12px 0; }
        
        .info-section {
            background: #f8fafc;
            padding: 10px 12px;
            border-radius: 6px;
            margin-bottom: 12px;
            font-size: 0.8rem;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
        }
        .info-row:last-child { margin-bottom: 0; }

        .table-items {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.8rem;
        }
        .table-items th {
            text-align: left;
            padding-bottom: 8px;
            border-bottom: 1px solid #e2e8f0;
            color: #64748b;
            font-size: 0.75rem;
        }
        .table-items td {
            padding: 8px 0;
            vertical-align: top;
        }
        .text-right { text-align: right; }
        
        .total-section {
            margin-top: 10px;
            font-size: 0.9rem;
        }
        .footer-note {
            text-align: center;
            font-size: 0.75rem;
            color: #ef4444;
            margin-top: 15px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .btn-print {
            background: #0f172a;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 50px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: 0.2s;
        }
        .btn-print:hover { background: #1e293b; }

        @media print {
            body { background: transparent; }
            .receipt-container { box-shadow: none; width: 100%; padding: 0; margin: 0; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

    <div class="receipt-container">
        <!-- Header Toko -->
        <div class="text-center">
            <div class="brand-title fw-bold">RIEL'S COFFEE</div>
            <div class="receipt-subtitle">*** STRUK ***</div>
        </div>

        <div class="divider"></div>

        <!-- Informasi Pesanan & Pelanggan -->
        <div class="info-section">
            <div class="info-row">
                <span>No. Pesanan:</span>
                <span class="fw-bold">#{{ $order->ID_PESANAN }}</span>
            </div>
            <div class="info-row">
                <span>Waktu:</span>
                <span>{{ date('d/m/Y H:i', strtotime($order->updated_at ?? now())) }}</span>
            </div>
            <div class="info-row">
                <span>No. Meja:</span>
                <span class="fw-bold" style="font-size: 0.9rem;">MEJA {{ $order->ID_MEJA }}</span>
            </div>
            <div class="info-row">
                <span>Atas Nama:</span>
                <span class="fw-bold">{{ optional($order->pelanggan)->NAMA_PELANGGAN ?? session('customer_nama', 'Pelanggan') }}</span>
            </div>
        </div>

        <!-- Tabel Rincian Menu -->
        <table class="table-items">
            <thead>
                <tr>
                    <th>MENU / QTY</th>
                    <th class="text-right">SUBTOTAL</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->detail as $item)
                <tr>
                    <td>
                        <div class="fw-bold">{{ optional($item->menu)->NAMA_MENU ?? 'Menu Dihapus' }}</div>
                        <div style="font-size: 0.75rem; color: #64748b;">
                            {{ $item->QTY }}x @ Rp {{ number_format(optional($item->menu)->HARGA_SATUAN ?? 0, 0, ',', '.') }}
                        </div>
                    </td>
                    <td class="text-right fw-bold" style="padding-top: 10px;">
                        Rp {{ number_format($item->SUBTOTAL, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="divider"></div>

        <!-- Total Keseluruhan -->
        <div class="total-section">
            <div class="info-row fw-bold" style="font-size: 1rem;">
                <span>TOTAL BAYAR:</span>
                <span style="color: #0d6efd;">Rp {{ number_format($order->TOTAL_BAYAR, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="divider"></div>

        <!-- Catatan Koki -->
        <div class="footer-note">
            ⚡ TERIMA KASIH SUDAH DATANG ⚡
        </div>
    </div>

    <!-- Tombol Cetak Manual (Hilang saat diprint) -->
    <button onclick="window.print()" class="btn-print no-print">
        <i class="bi bi-printer-fill me-2"></i> Cetak Struk Dapur
    </button>

</body>
</html>