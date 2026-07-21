<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\DetilPemesanan; 
use App\Models\Resep;
use App\Models\Stokbahan;
use Illuminate\Http\Request;

class DapurController extends Controller 
{
    public function index() 
    {
        // Hapus with('detilPemesanan') agar tidak error relasi
        $pesananAntre = Pemesanan::where('STATUS_PESANAN', 'Antre')->get(); 
        $pesananDimasak = Pemesanan::where('STATUS_PESANAN', 'Dimasak')->get();
        
        return view('dapur.index', compact('pesananAntre', 'pesananDimasak'));
    }

    public function updateStatus($id) 
    {
        $pesanan = Pemesanan::findOrFail($id);
        
        // Alur: Antre -> Dimasak (sekaligus kurangi stok bahan resep) -> Siap
        if ($pesanan->STATUS_PESANAN == 'Antre') {
            $items = DetilPemesanan::where('ID_PESANAN', $id)->get();

            foreach ($items as $item) {
                $reseps = Resep::where('ID_MENU', $item->ID_MENU)->get();

                foreach ($reseps as $resep) {
                    $bahan = Stokbahan::find($resep->ID_BAHAN_STOK);
                    if ($bahan) {
                        $jumlahKebutuhan = $item->JUMLAH ?? $item->QTY ?? $item->JUMLAH_PESANAN ?? 1;
                        $bahan->JUMLAH_BAHAN -= ($resep->JUMLAH_KEBUTUHAN * $jumlahKebutuhan);
                        $bahan->save();
                    }
                }
            }

            $pesanan->update(['STATUS_PESANAN' => 'Dimasak']);

        } elseif ($pesanan->STATUS_PESANAN == 'Dimasak') {
            $pesanan->update(['STATUS_PESANAN' => 'Siap']);
        }
        
        return redirect()->back();
    }
    public function cetakStrukDapur($id) {
        $order = \App\Models\Pemesanan::with(['detail.menu'])->findOrFail($id);
        
        // Otomatis ubah status ke 'Dimasak' saat bon dapur dicetak
        if ($order->STATUS_PESANAN == 'Antre') {
            $order->update(['STATUS_PESANAN' => 'Dimasak']);
        }
    
        return view('kasir.struk_dapur', compact('order'));
    }
    public function cetakSemuaAntrean() {
        $pesananAntre = \App\Models\Pemesanan::where('STATUS_PESANAN', 'Antre')->get();
        
        // Ubah semua status pesanan antre menjadi 'Dimasak'
        \App\Models\Pemesanan::where('STATUS_PESANAN', 'Antre')->update(['STATUS_PESANAN' => 'Dimasak']);
    
        return view('kasir.struk_semua_antrean', compact('pesananAntre'));
    }
}