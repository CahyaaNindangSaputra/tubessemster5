<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang - Riels Coffee</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Plus Jakarta Sans', sans-serif; }
        .cart-item { border-left: 5px solid #0d6efd; transition: 0.3s; }
        .cart-item:hover { transform: translateX(5px); }
        .btn-qty { width: 30px; height: 30px; padding: 0; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-weight: bold; }
    </style>
</head>
<body class="d-flex align-items-center min-vh-100 py-4">

    <div class="container" style="max-width: 500px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0"><i class="bi bi-cart-check-fill text-primary me-2"></i>Keranjang</h4>
            <span class="badge bg-secondary rounded-pill">Meja {{ session('customer_meja') }}</span>
        </div>

        @if(session('cart') && count(session('cart')) > 0)
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="card-body p-0">
                    @foreach(session('cart') as $id => $details)
                    <div class="cart-item p-3 border-bottom bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                @if(isset($details['foto']) && $details['foto'])
                                    <img src="/images/menu/{{ $details['foto'] }}" class="rounded-3 me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded-3 me-3 d-flex align-items-center justify-content-center text-muted small" style="width: 50px; height: 50px;">No Pic</div>
                                @endif
                                <div>
                                    <h6 class="fw-bold mb-1">{{ $details['name'] }}</h6>
                                    <small class="text-primary fw-bold">Rp {{ number_format($details['price'], 0, ',', '.') }}</small>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-center bg-light rounded-pill px-2 py-1">
                                <form action="{{ route('cart.remove', $id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-white text-danger btn-qty shadow-sm"><i class="bi bi-dash"></i></button>
                                </form>
                                
                                <span class="mx-3 fw-bold small">{{ $details['quantity'] }}</span>
                                
                                <form action="{{ route('cart.increase', $id) }}" method="POST" class="d-inline">
                                    @csrf 
                                    <button type="submit" class="btn btn-sm btn-white text-success btn-qty shadow-sm"><i class="bi bi-plus"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    <div class="p-4 bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted fw-bold">Total Bayar</span>
                            <h4 class="fw-bold text-primary mb-0">Rp {{ number_format($total, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('customer.checkout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success w-100 rounded-pill fw-bold py-3 shadow-lg mb-3">
                    Lanjut Pembayaran <i class="bi bi-arrow-right-circle ms-2"></i>
                </button>
            </form>

        @else
            <div class="text-center py-5">
                <i class="bi bi-cart-x fs-1 text-muted opacity-50"></i>
                <h5 class="fw-bold mt-3 text-muted">Keranjang Kosong</h5>
                <p class="small text-muted mb-4">Yuk pesan sesuatu yang enak!</p>
                <a href="{{ route('customer.menu') }}" class="btn btn-primary rounded-pill px-4 fw-bold">Lihat Menu</a>
            </div>
        @endif

        @if(session('cart') && count(session('cart')) > 0)
            <div class="text-center">
                <a href="{{ route('customer.menu') }}" class="text-decoration-none text-muted small fw-bold">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Menu Lain
                </a>
            </div>
        @endif
    </div>

</body>
</html>