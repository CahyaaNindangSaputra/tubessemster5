<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Semua Antrean Dapur - Riels Coffee</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            color: #000;
            width: 58mm; /* Lebar standar kertas thermal kasir */
            margin: 0 auto;
            padding: 5px;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
            border-bottom: 1px dashed #000;
            padding-bottom: 8px;
        }
        .header h3 {
            margin: 0;
            font-size: 14px;
            font-weight: bold;
        }
        .header p {
            margin: 2px 0;
            font-size: 10px;
        }
        .order-box {
            margin-bottom: 15px;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
        }
        .order-info {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 13px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }
        th, td {
            text-align: left;
            font-size: 11px;
            padding: 2px 0;
        }
        .text-end {
            text-align: right;
        }
        .footer {
            text-align: center;
            margin-top: 15px;
            font-size: 10px;
            border-top: 1px dashed #000;
            padding-top: 5px;
        }
        @media print {
            body {
                width: 58mm;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h3>RIEL'S COFFEE</h3>
        <p>REKAP STRUK ANTREAN DAPUR</p>
        <p>{{ date('d/m/Y H:i:s') }}</p>
    </div>

    @forelse($pesananAntre as $order)
        <div class="order-box">
            <div class="order-info">
                <span>#{{ $order->ID_PESANAN }}</span>
                <span>Meja: {{ $order->ID_MEJA }}</span>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Menu</th>
                        <th class="text-end">Qty</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->detail as $item)
                    <tr>
                        <td>{{ $item->menu->NAMA_MENU ?? 'Menu Dihapus' }}</td>
                        <td class="text-end">x{{ $item->QTY }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @if(!empty($order->CATATAN))
                <div style="font-size: 10px; font-style: italic; margin-top: 3px;">
                    Catatan: {{ $order->CATATAN }}
                </div>
            @endif
        </div>
    @empty
        <div style="text-align: center; padding: 10px;">
            <p>Tidak ada antrean pesanan.</p>
        </div>
    @endforelse

    <div class="footer">
        <p>*** Harap Segera Disiapkan ***</p>
    </div>

</body>
</html>