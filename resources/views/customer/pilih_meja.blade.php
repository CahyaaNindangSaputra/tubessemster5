<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di Riels Coffee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-btn { height: 100px; font-size: 24px; font-weight: bold; border-radius: 15px; transition: 0.3s; cursor: pointer; }
        /* Warna saat meja dipilih */
        .btn-check:checked + .table-btn { 
            background-color: #198754 !important; 
            color: white !important; 
            border-color: #198754 !important;
            box-shadow: 0 0 15px rgba(25, 135, 84, 0.5);
        }
        .table-btn:hover { transform: scale(1.05); }
    </style>
</head>
<body class="bg-dark text-white d-flex align-items-center" style="min-height: 100vh;">
    <div class="container text-center">
        <h1 class="mb-2">RIELS COFFEE</h1>
        <p class="text-secondary mb-5">Silakan pilih nomor meja Anda</p>

        <form action="{{ route('customer.setTable') }}" method="POST">
            @csrf 
            
            <div class="row g-3 justify-content-center">
                @foreach($daftarMeja as $meja)
                <div class="col-4 col-md-2">
                    <input type="radio" class="btn-check" name="id_meja" id="meja{{ $meja->ID_MEJA }}" value="{{ $meja->ID_MEJA }}" autocomplete="off" required>
                    
                    <label class="btn btn-outline-success w-100 table-btn d-flex align-items-center justify-content-center" for="meja{{ $meja->ID_MEJA }}">
                       
                        {{ $meja->ID_MEJA }}
                    </label>
                </div>
                @endforeach
            </div>

            <div class="mt-5">
             
                <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill shadow">Lihat Menu</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>