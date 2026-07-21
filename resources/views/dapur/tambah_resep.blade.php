<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Resep Dapur - Riels Coffee</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8fafc; font-family: 'Plus Jakarta Sans', sans-serif; color: #1e293b; }
        .bahan-box { max-height: 280px; overflow-y: auto; border: 1px solid #e2e8f0; border-radius: 16px; padding: 15px; background: #fff; }
        .bahan-item { display: flex; align-items: center; justify-content: space-between; padding: 8px 12px; border-bottom: 1px solid #f1f5f9; transition: background 0.2s; }
        .bahan-item:hover { background-color: #f8fafc; border-radius: 10px; }
    </style>
</head>
<body class="py-5">
    <div class="container" style="max-width: 700px;">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <h4 class="fw-bold mb-4 text-dark"><i class="bi bi-journal-plus text-primary me-2"></i> Tambah Resep Menu (Multi-Bahan)</h4>
            
            <form action="{{ route('dapur.resep.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="form-label small fw-bold text-uppercase text-muted">Pilih Menu</label>
                    <select name="id_menu" class="form-select rounded-pill px-4 py-2.5 bg-light border-0 fw-semibold" required>
                        <option value="">-- Pilih Menu Makanan / Minuman --</option>
                        @foreach($menus as $menu)
                            <option value="{{ $menu->ID_MENU }}">{{ $menu->NAMA_MENU }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-bold text-uppercase text-muted mb-2">Pilih Bahan Baku & Tentukan Takaran Porsi</label>
                    
                    <!-- Search Bar untuk Bahan Baku -->
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-light border-end-0 text-muted rounded-start-pill ps-3"><i class="bi bi-search"></i></span>
                        <input type="text" id="searchBahan" class="form-control border-start-0 bg-light rounded-end-pill py-2" placeholder="Cari nama bahan baku...">
                    </div>

                    <div class="bahan-box shadow-sm" id="listBahanContainer">
                        @foreach($stokBahans as $bahan)
                        <div class="bahan-item">
                            <div class="form-check d-flex align-items-center gap-2 flex-grow-1">
                                <input class="form-check-input mt-0" type="checkbox" name="bahan[{{ $bahan->id_bahan }}][pilih]" value="1" id="bahan_{{ $bahan->id_bahan }}">
                                <label class="form-check-label fw-medium text-dark small nama-bahan" for="bahan_{{ $bahan->id_bahan }}">
                                    {{ $bahan->nama_bahan }} <span class="text-muted" style="font-size: 11px;">(Stok: {{ $bahan->jumlah_bahan }} {{ $bahan->satuan }})</span>
                                </label>
                            </div>
                            <div style="width: 140px;">
                                <div class="input-group input-group-sm">
                                    <input type="number" step="any" name="bahan[{{ $bahan->id_bahan }}][jumlah]" class="form-control border bg-light text-center" placeholder="Takaran">
                                    <span class="input-group-text bg-white text-muted small px-2">{{ $bahan->satuan }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary rounded-pill w-100 fw-bold py-2.5 shadow-sm">Simpan Semua Resep</button>
                    <a href="{{ route('dapur.resep.index') }}" class="btn btn-light rounded-pill w-100 fw-bold py-2.5 border">Kembali</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Script JavaScript untuk Filter Pencarian Real-Time -->
    <script>
        document.getElementById('searchBahan').addEventListener('keyup', function() {
            let keyword = this.value.toLowerCase();
            let items = document.querySelectorAll('.bahan-item');

            items.forEach(function(item) {
                let namaBahan = item.querySelector('.nama-bahan').textContent.toLowerCase();
                if (namaBahan.includes(keyword)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>