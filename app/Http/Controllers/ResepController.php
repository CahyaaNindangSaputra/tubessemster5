<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resep;
use App\Models\Menu;
use App\Models\Stokbahan;

class ResepController extends Controller
{
    public function index() {
        // Ambil semua data resep dengan relasi, lalu group berdasarkan id_menu
        $daftarResep = Resep::with(['menu', 'stokBahan'])
                            ->whereNotNull('id_menu')
                            ->get()
                            ->groupBy('id_menu');
        
        return view('dapur.resep_index', compact('daftarResep'));
    }

    public function create() {
        $menus = Menu::all();
        $stokBahans = Stokbahan::all();
        return view('dapur.tambah_resep', compact('menus', 'stokBahans'));
    }
    public function store(Request $request) {
        // Tangkap ID Menu dari select form (pastikan name-nya sesuai: id_menu atau ID_MENU)
        $idMenu = $request->id_menu ?? $request->ID_MENU;
    
        // Pastikan ada bahan yang dicentang
        if ($request->has('bahan')) {
            foreach ($request->bahan as $idBahan => $dataBahan) {
                // Ambil nilai jumlah/takaran tergantung format input
                $jumlah = is_array($dataBahan) ? ($dataBahan['jumlah'] ?? null) : $dataBahan;
                
                // Cek apakah dicentang (jika pakai struktur array [pilih] & [jumlah])
                $isPilih = is_array($dataBahan) ? isset($dataBahan['pilih']) : true;
    
                if ($isPilih && !empty($jumlah)) {
                    Resep::create([
                        'id_menu' => $idMenu, // <-- INI HARUS DINAMIS SESUAI DROPDOWN, BUKAN HARDCODE!
                        'ID_BAHAN_STOK' => $idBahan,
                        'JUMLAH_KEBUTUHAN' => $jumlah,
                    ]);
                }
            }
        }
    
        return redirect()->route('dapur.resep.index')->with('success', 'Resep menu berhasil ditambahkan!');
    }
    public function destroy($id) {
        // Hapus berdasarkan id_menu
        Resep::where('id_menu', $id)->delete();
    
        return redirect()->back()->with('success', 'Resep menu berhasil dihapus!');
    }
    public function edit($id) {
        $menu = \App\Models\Menu::findOrFail($id);
        $menus = \App\Models\Menu::all();
        $stokBahans = \App\Models\StokBahan::all();
    
        // Ubah 'ID_BAHAN_STOK' sesuaikan dengan nama kolom foreign key bahan di tabel resep kamu
        $resepTerpilih = Resep::where('id_menu', $id)->get()->keyBy('ID_BAHAN_STOK'); 
    
        return view('dapur.resep_edit', compact('menu', 'menus', 'stokBahans', 'resepTerpilih'));
    }
    
    public function update(Request $request, $id) {
        // Hapus dulu resep lama untuk menu ini, lalu masukkan yang baru (cara paling bersih & aman untuk multi-bahan)
        Resep::where('id_menu', $id)->delete();
    
        $idMenu = $request->id_menu;
    
        if ($request->has('bahan')) {
            foreach ($request->bahan as $idBahan => $dataBahan) {
                $jumlah = is_array($dataBahan) ? ($dataBahan['jumlah'] ?? null) : $dataBahan;
                $isPilih = is_array($dataBahan) ? isset($dataBahan['pilih']) : true;
    
                if ($isPilih && !empty($jumlah)) {
                    Resep::create([
                        'id_menu' => $idMenu,
                        'ID_BAHAN_STOK' => $idBahan,
                        'JUMLAH_KEBUTUHAN' => $jumlah,
                    ]);
                }
            }
        }
    
        return redirect()->route('dapur.resep.index')->with('success', 'Resep menu berhasil diperbarui!');
    }
}