<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('meja')) {
            $mejaAktif = $request->query('meja');
            session(['customer_meja' => $mejaAktif]);
        } else {
            $mejaAktif = session('customer_meja', 'A1');
        }
        
        $riwayatPesanan = \App\Models\Pemesanan::with('detail.menu')
                        ->where('ID_MEJA', $mejaAktif)
                        ->get();
        
        $daftarMenu = \App\Models\Menu::with('resep.stokBahan')->get();
    
        foreach ($daftarMenu as $menu) {
            $menu->is_tersedia = true;
    
            foreach ($menu->resep as $resep) {
                $stokBahan = $resep->stokBahan;
    
                if (!$stokBahan || $stokBahan->JUMLAH_BAHAN < $resep->JUMLAH_KEBUTUHAN) {
                    $menu->is_tersedia = false;
                    break;
                }
            }
        }
        
        $nomorMeja = $mejaAktif;
    
        return view('customer.index', compact('daftarMenu', 'riwayatPesanan', 'nomorMeja'));
    }
    
    public function addToCart($id) {
        if (!session()->has('customer_meja')) return redirect()->route('customer.direct', ['id_meja' => 'A1']);
        
        $menu = \App\Models\Menu::with('resep.stokBahan')->findOrFail($id);
        
        foreach ($menu->resep as $resep) {
            $stokBahan = $resep->stokBahan;
            if (!$stokBahan || $stokBahan->JUMLAH_BAHAN < $resep->JUMLAH_KEBUTUHAN) {
                return redirect()->back()->with('error', 'Maaf, bahan baku untuk menu ' . $menu->NAMA_MENU . ' sedang tidak mencukupi!');
            }
        }
    
        $cart = session()->get('cart', []);
        if(isset($cart[$id])) { 
            $cart[$id]['quantity']++; 
        } else { 
            $cart[$id] = ["name" => $menu->NAMA_MENU, "quantity" => 1, "price" => $menu->HARGA_SATUAN, "foto" => $menu->FOTO]; 
        }
        session()->put('cart', $cart); 
        
        return redirect()->back();
    }
    public function confirmPayment(Request $request) {
        $id_pesanan = session('last_order_id');
        $id_metode = $request->id_metode;

        if (!$id_pesanan) {
            return redirect()->route('customer.menu')->with('error', 'Sesi pesanan habis.');
        }

        DB::table('pemesanan')
            ->where('ID_PESANAN', $id_pesanan)
            ->update([
                'ID_METODE' => $id_metode
            ]);
            
        return redirect()->route('customer.menu')->with('success', 'Pesanan Anda sedang diproses dapur!');
    }

    public function showPaymentPage() {
        $id_pesanan = session('last_order_id');
        
        if (!$id_pesanan) {
            return redirect()->route('customer.menu')->with('error', 'Sesi pembayaran berakhir.');
        }

        $order = \App\Models\Pemesanan::where('ID_PESANAN', $id_pesanan)->firstOrFail();
        $metodeBayar = DB::table('metode_pembayaran')->get();

        return view('customer.payment', compact('order', 'metodeBayar'));
    }

    public function increaseCart($id)
    {
        $cart = session()->get('cart');

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Jumlah pesanan ditambah!');
    }

    public function store(Request $request)
    {
        $idMeja = $request->input('id_meja') ?? $request->query('meja');

        $pemesanan = Pemesanan::create([
            'ID_MEJA' => $idMeja,
            'NAMA_PELANGGAN' => $request->input('nama'),
        ]);

        session(['last_order_id_' . $idMeja => $pemesanan->ID_PESANAN]);

        return redirect()->route('customer.menu', ['meja' => $idMeja])->with('success', 'Pesanan Diterima!');
    }

    public function checkout(Request $request)
    {
        $nomorMeja = $request->input('meja') ?? $request->query('meja') ?? session('customer_meja');

        $cart = session()->get('cart', []);
        if(!$cart) {
            return redirect()->back()->with('error', 'Keranjang kosong!');
        }

        $totalBayar = 0;
        foreach($cart as $id => $details) {
            $totalBayar += $details['price'] * $details['quantity'];
        }

        $pemesanan = \App\Models\Pemesanan::create([
            'ID_MEJA' => $nomorMeja,
            'NAMA_PELANGGAN' => session('customer_nama_' . $nomorMeja) ?? session('customer_nama', 'Pelanggan'),
            'TOTAL_BAYAR' => $totalBayar,
            'STATUS_PESANAN' => 'Proses',
            'TGL_PESANAN' => now(),
        ]);

        session(['last_order_id_' . $nomorMeja => $pemesanan->ID_PESANAN]);
        session(['last_order_id' => $pemesanan->ID_PESANAN]);

        // Simpan detail pesanan (Tanpa memotong stok di sini, mutlak diatur di KasirController)
        foreach($cart as $id => $details) {
            DB::table('detil_pemesanan')->insert([
                'ID_PESANAN' => $pemesanan->ID_PESANAN,
                'ID_MENU' => $id,
                'QTY' => $details['quantity'],
                'SUBTOTAL' => $details['price'] * $details['quantity']
            ]);
        }

        session()->forget('cart');

        return redirect()->to('/menu-pelanggan?meja=' . $nomorMeja)->with('success', 'Pesanan Berhasil Dibuat!');
    }
}