<div class="container py-4">
    <h4 class="fw-bold mb-4">Status Pesanan Meja {{ session('customer_meja') }}</h4>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-warning text-dark fw-bold">⏳ Sedang Diproses</div>
        <div class="card-body">
            @forelse($pesananProses as $p)
                <div class="mb-3 border-bottom pb-2">
                    <span class="badge bg-dark">#{{ $p->ID_PESANAN }}</span>
                    <ul class="mt-2 small">
                        @foreach($p->detail as $item)
                            <li>{{ $item->menu->NAMA_MENU }} (x{{ $item->QTY }})</li>
                        @endforeach
                    </ul>
                </div>
            @empty
                <p class="text-muted small">Tidak ada pesanan yang sedang diproses.</p>
            @endforelse
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-success text-white fw-bold">✅ Selesai & Terbayar</div>
        <div class="card-body">
            @forelse($pesananTerbayar as $p)
                <div class="d-flex justify-content-between align-items-center mb-2 border-bottom pb-2">
                    <div>
                        <p class="mb-0 fw-bold">#{{ $p->ID_PESANAN }}</p>
                        <small class="text-muted">{{ count($p->detail) }} Menu</small>
                    </div>
                    <span class="text-success fw-bold">LUNAS</span>
                </div>
            @empty
                <p class="text-muted small">Belum ada riwayat pesanan selesai.</p>
            @endforelse
        </div>
    </div>
</div>