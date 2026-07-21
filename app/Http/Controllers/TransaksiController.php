<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Resep;
use App\Models\StokBahan;

class TransaksiController extends Controller
{
    public function store(Request $request) {
        // 1. Simpan data transaksi utama terlebih dahulu
        $transaksi = Transaksi::create([
            'nama_pelanggan' => $request->nama_pelanggan,
            'total_harga' => $request->total_harga,
            // ... field lainnya ...
        ]);
    
        // 2. Loop data item menu yang dipesan oleh customer
        foreach ($request->items as $item) {
            $idMenu = $item['id_menu'];
            $jumlahPorsi = $item['jumlah_porsi']; // misal: 1 porsi
    
            // Simpan detail pesanannya
            DetailTransaksi::create([
                'id_transaksi' => $transaksi->id,
                'id_menu' => $idMenu,
                'jumlah' => $jumlahPorsi,
            ]);
    
            // ==========================================
            // 3. LOGIKA OTOMATIS MENGURANGI STOK GUDANG
            // ==========================================
            
            // Ambil semua resep yang terikat dengan menu ini
            $resepList = Resep::where('id_menu', $idMenu)->get();
    
            foreach ($resepList as $resep) {
                $idBahan = $resep->ID_BAHAN_STOK; // sesuaikan nama kolom foreign key bahan
                $takaranPerPorsi = $resep->JUMLAH_KEBUTUHAN; // misal: butuh 45 gram per porsi
    
                // Hitung total bahan yang harus dikurangi (Takaran x Jumlah Porsi Pesanan)
                $totalPengurangan = $takaranPerPorsi * $jumlahPorsi;
    
                // Kurangi stok di tabel gudang/stok_bahan
                $bahanGudang = StokBahan::find($idBahan);
                if ($bahanGudang) {
                    // Pastikan nama kolom stok di database kamu sesuai (misal: 'stok' atau 'jumlah_bahan')
                    $bahanGudang->stok -= $totalPengurangan; 
                    
                    // Opsional: cegah minus jika stok gudang kurang
                    if ($bahanGudang->stok < 0) {
                        $bahanGudang->stok = 0; 
                    }
    
                    $bahanGudang->save();
                }
            }
        }
    
        return redirect()->route('kasir.index')->with('success', 'Pesanan berhasil diproses dan stok gudang terpotong otomatis!');
    }
}