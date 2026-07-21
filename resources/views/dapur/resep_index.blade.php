<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Resep Dapur - Riels Coffee</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root { --sidebar-width: 280px; }
        body { background-color: #f8fafc; font-family: 'Plus Jakarta Sans', sans-serif; color: #1e293b; }
        .sidebar-right { width: var(--sidebar-width); position: fixed; right: 0; top: 0; height: 100vh; background: #ffffff; border-left: 1px solid #e2e8f0; padding: 35px 25px; z-index: 1000; display: flex; flex-direction: column; justify-content: space-between; }
        .sidebar-right .nav-link { border-radius: 12px; font-weight: 600; padding: 12px 18px; color: #64748b; transition: all 0.3s ease; }
        .sidebar-right .nav-link.active { background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%); color: #ffffff; box-shadow: 0 4px 12px rgba(13, 110, 253, 0.25); }
        .main-content { margin-right: var(--sidebar-width); padding: 40px; min-height: 100vh; }
        .card-modern { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 24px; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.04); overflow: hidden; margin-bottom: 24px; }
        .table thead th { background-color: #f8fafc; color: #64748b; text-transform: uppercase; font-size: 0.75rem; font-weight: 700; padding: 16px 20px; }
        .table tbody td { padding: 18px 20px; vertical-align: middle; }
    </style>
</head>
<body>

    <!-- Sidebar Dapur -->
    <div class="sidebar-right">
        <div>
            <div class="text-center mb-5">
                <h4 class="fw-bold mb-1 text-primary"><i class="bi bi-cup-hot-fill me-1"></i> RIEL'S<span class="text-dark">COFFE</span></h4>
                <p class="text-muted small fw-medium">Panel Dapur & Resep</p>
            </div>
            <div class="nav flex-column nav-pills gap-2">
                <a href="{{ url('/dapur') }}" class="nav-link d-flex align-items-center"><i class="bi bi-fire fs-5 me-3"></i> Monitor Dapur</a>
                <a href="{{ route('dapur.resep.index') }}" class="nav-link active d-flex align-items-center"><i class="bi bi-journal-text fs-5 me-3"></i> Kelola Resep</a>
            </div>
        </div>
        <div class="text-center text-muted small pb-2">&copy; 2026 Riels Coffee</div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Daftar Resep Menu</h2>
                <p class="text-muted small mb-0">Atur takaran bahan baku yang terhubung otomatis dengan pemotongan stok gudang.</p>
            </div>
            <a href="{{ route('dapur.resep.tambah') }}" class="btn btn-primary rounded-pill fw-bold shadow-sm px-4 py-2">
                <i class="bi bi-plus-lg me-2"></i> Tambah Resep Baru
            </a>
        </div>

        <div class="card-modern">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NAMA MENU</th>
                            <th>BAHAN BAKU GUDANG</th>
                            <th>TAKARAN KEBUTUHAN</th>
                            <th class="text-end">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($daftarResep as $idMenu => $resepGroup)
                        <tr>
                            {{-- Nomor Urut Sesuai Grup --}}
                            <td class="fw-bold text-muted align-middle" style="width: 5%;">{{ $loop->iteration }}</td>
                            
                            {{-- Nama Menu --}}
                            <td class="fw-bold text-primary align-middle" style="width: 25%;">
                                {{ $resepGroup->first()->menu->NAMA_MENU ?? $resepGroup->first()->menu->nama_menu ?? 'Menu Tidak Ditemukan' }}
                            </td>
                            
                            {{-- Daftar Bahan Baku --}}
                            <td class="align-middle" style="width: 35%;">
                                <ul class="list-unstyled mb-0">
                                    @foreach($resepGroup as $r)
                                        <li class="mb-2">
                                            <span class="badge bg-dark rounded-pill px-3 py-2 text-white">
                                                {{ $r->stokBahan->nama_bahan ?? 'Bahan Dihapus' }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                    
                            {{-- Takaran Kebutuhan --}}
                            <td class="align-middle" style="width: 25%;">
                                <ul class="list-unstyled mb-0">
                                    @foreach($resepGroup as $r)
                                        <li class="mb-2 py-1 fw-semibold text-dark">
                                            {{ $r->JUMLAH_KEBUTUHAN ?? $r->jumlah_kebutuhan ?? '0' }} {{ $r->stokBahan->satuan ?? '' }}
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                    
                            {{-- Tombol Hapus Berdasarkan Menu --}}
                            <td class="text-end align-middle" style="width: 10%;">
                                <div class="d-flex justify-content-end gap-1">
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('dapur.resep.edit', $idMenu) }}" class="btn btn-sm btn-light border rounded-circle text-primary shadow-sm d-inline-flex align-items-center justify-content-center" title="Edit Resep Menu Ini" style="width: 32px; height: 32px;">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                <form action="{{ route('dapur.resep.destroy', $idMenu) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus seluruh resep untuk menu ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light border rounded-circle text-danger shadow-sm d-inline-flex align-items-center justify-content-center" title="Hapus Resep Menu Ini" style="width: 32px; height: 32px;">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-journal-x fs-2 d-block mb-2 opacity-50"></i>
                                Belum ada data resep yang tersimpan di dapur.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        @if(session('success'))
            Swal.fire({icon:'success', title:'Berhasil!', text:'{{ session('success') }}', timer:2000, showConfirmButton:false});
        @endif
    </script>
</body>
</html>