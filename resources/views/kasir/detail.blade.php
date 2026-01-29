<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Pesanan #{{ $pesanan->id_pesanan }}</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Detail Pesanan #{{ $pesanan->id_pesanan }}</h2>
            <a href="{{ route('kasir.index') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">Info Transaksi</div>
                    <div class="card-body">
                        <p><strong>Meja:</strong> {{ $pesanan->id_meja }}</p>
                        <p><strong>ID Pelanggan:</strong> {{ $pesanan->id_pelanggan }}</p>
                        <p><strong>Status:</strong> 
                            @if($pesanan->id_pembayaran)
                                <span class="badge bg-success">Sudah Bayar</span>
                            @else
                                <span class="badge bg-danger">Menunggu Pembayaran</span>
                            @endif
                        </p>
                        <hr>
                        <h4>Total: Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">Item Pesanan</div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Menu</th>
                                    <th>Harga Satuan</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                <tr>
                                    <td>{{ $item->menu->nama_menu }}</td>
                                    <td>Rp {{ number_format($item->menu->harga_satuan, 0, ',', '.') }}</td>
                                    <td>{{ $item->qty }}x</td>
                                    <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>