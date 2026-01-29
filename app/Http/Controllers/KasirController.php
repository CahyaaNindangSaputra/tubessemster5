<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use App\Models\Menu;
use App\Models\Pemesanan;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    // ==========================================
    // 1. DASHBOARD KASIR
    // ==========================================
    public function index(Request $request) {
        date_default_timezone_set('Asia/Jakarta');
        $tanggalFilter = $request->get('tanggal', date('Y-m-d'));
        
        $mejaTerisi = Pemesanan::whereIn('STATUS_PESANAN', ['Proses', 'Dimasak', 'Siap'])
            ->pluck('ID_MEJA')->toArray();
    
        $menungguBayar = Pemesanan::where('STATUS_PESANAN', 'Menunggu')->get();
        $sedangProses = Pemesanan::whereIn('STATUS_PESANAN', ['Proses', 'Dimasak', 'Siap'])->get();
    
        $riwayatSelesai = Pemesanan::where('STATUS_PESANAN', 'Selesai')
            ->whereHas('pembayaran', function($query) use ($tanggalFilter) {
                $query->whereDate('WAKTU_PEMBAYARAN', $tanggalFilter);
            })->with(['detail.menu', 'pembayaran'])->latest('ID_PESANAN')->get();
    
        $daftarMeja = Meja::all();
        $daftarMenu = Menu::all();
        $metodeBayar = DB::table('metode_pembayaran')->get(); 
    
        return view('kasir.dashboard', compact(
            'daftarMeja', 'mejaTerisi', 'menungguBayar', 'sedangProses', 
            'riwayatSelesai', 'tanggalFilter', 'daftarMenu', 'metodeBayar'
        ));
    }

    // ==========================================
    // 2. CUSTOMER (PEMESANAN DARI HP)
    // ==========================================
    public function checkout(Request $request) {
        $cart = session()->get('cart');
        if(!$cart) return redirect()->back();
        
        $total = 0;
        foreach($cart as $d) { $total += $d['price'] * $d['quantity']; }
        
        if (!$request->session()->has('customer_nama') && $request->has('nama_pelanggan')) {
            $request->session()->put('customer_nama', $request->nama_pelanggan);
            $request->session()->put('customer_phone', $request->nomor_hp);
        }

        $id_pesanan = rand(1000, 9999);
        
        Pemesanan::create([
            'ID_PESANAN' => $id_pesanan,
            'ID_MEJA' => session('customer_meja'),
            'TOTAL_BAYAR' => $total,
            'STATUS_PESANAN' => 'Menunggu', 
        ]);
    
        foreach($cart as $id_menu => $d) {
            DB::table('detil_pemesanan')->insert([
                'DETIL_PEMESANAN' => rand(100000, 999999), 
                'ID_PESANAN' => $id_pesanan, 'ID_MENU' => $id_menu,
                'QTY' => $d['quantity'], 'SUBTOTAL' => $d['price'] * $d['quantity']
            ]);
        }
        
        session()->forget('cart');
        session(['last_order_id' => $id_pesanan]);
        
        return redirect()->route('customer.payment');
    }

    public function showPaymentPage() {
        $id_pesanan = session('last_order_id');
        if (!$id_pesanan) return redirect()->route('customer.menu');
        
        $order = Pemesanan::where('ID_PESANAN', $id_pesanan)->firstOrFail();
        $metodeBayar = DB::table('metode_pembayaran')->get();
        return view('customer.payment', compact('order', 'metodeBayar'));
    }

    public function confirmPayment(Request $request) {
        $id_pesanan = session('last_order_id');
        
        $request->validate([
            'id_metode' => 'required',
            'nama_pelanggan' => 'required',
            'nomor_hp' => 'required'
        ]);

        $id_pelanggan = 'P' . rand(1000, 9999);
        Pelanggan::create([
            'ID_PELANGGAN' => $id_pelanggan,
            'NAMA_PELANGGAN' => $request->nama_pelanggan,
            'NO_HP' => $request->nomor_hp
        ]);

        try {
            DB::table('pemesanan')->where('ID_PESANAN', $id_pesanan)
                ->update(['ID_PELANGGAN' => $id_pelanggan]);
        } catch (\Exception $e) {}

        session(['customer_nama' => $request->nama_pelanggan]); 
        session(['customer_phone' => $request->nomor_hp]);

        $metode = DB::table('metode_pembayaran')->where('ID_METODE', $request->id_metode)->first();
        $namaMetode = strtoupper($metode->NAMA_METODE);

        if (str_contains($namaMetode, 'QRIS')) {
            session(['temp_id_metode' => $request->id_metode]);
            return redirect()->route('customer.qris', $id_pesanan);
        } else {
            DB::table('pemesanan')->where('ID_PESANAN', $id_pesanan)
                ->update(['STATUS_PESANAN' => 'Menunggu']);
            
            session()->forget('last_order_id'); 
            return redirect()->route('customer.menu')
                ->with('warning', 'Mohon segera menuju KASIR untuk melakukan pembayaran tunai.');
        }
    }

    public function showQrisPage($id) {
        $order = Pemesanan::findOrFail($id);
        return view('customer.qris', compact('order'));
    }

    public function markQrisPaid($id) {
        $id_metode = session('temp_id_metode'); 
        
        DB::table('pemesanan')->where('ID_PESANAN', $id)
            ->update(['STATUS_PESANAN' => 'Proses']);

        DB::table('pembayaran')->insert([
            'ID_PEMBAYARAN'     => 'B' . rand(1000, 9999),
            'ID_PESANAN'        => $id,
            'ID_METODE'         => $id_metode,
            'STATUS_PEMBAYARAN' => 'Lunas',
            'WAKTU_PEMBAYARAN'  => now()
        ]);

        session()->forget('last_order_id');
        session()->forget('temp_id_metode');

        return redirect()->route('customer.menu')
            ->with('success', 'Pembayaran QRIS Berhasil! Pesanan langsung masuk dapur.');
    }

    // ==========================================
    // 3. ADMIN / KASIR ACTIONS
    // ==========================================
    public function prosesBayar(Request $request, $id) {
        if (!$request->id_metode) {
            return redirect()->back()->with('error', 'PILIH METODE BAYAR DULU BOSS!');
        }

        DB::table('pemesanan')->where('ID_PESANAN', $id)->update(['STATUS_PESANAN' => 'Proses']);

        DB::table('pembayaran')->insert([
            'ID_PEMBAYARAN'     => 'B' . rand(1000, 9999),
            'ID_PESANAN'        => $id,
            'ID_METODE'         => $request->id_metode,
            'STATUS_PEMBAYARAN' => 'Lunas', 
            'WAKTU_PEMBAYARAN'  => now()
        ]);

        return redirect()->back()->with('success', 'SUKSES! Masuk Dapur.');
    }

    public function updateStatus($id) {
        $pesanan = Pemesanan::findOrFail($id);
        $statusMap = ['Proses' => 'Dimasak', 'Dimasak' => 'Siap', 'Siap' => 'Selesai'];
        
        if (array_key_exists($pesanan->STATUS_PESANAN, $statusMap)) {
            $pesanan->update(['STATUS_PESANAN' => $statusMap[$pesanan->STATUS_PESANAN]]);
            if ($pesanan->STATUS_PESANAN == 'Selesai') session()->forget('cart');
        }
        return redirect()->back();
    }

    // ==========================================
    // 4. MANAJEMEN MENU (CRUD) - DIPERBAIKI!
    // ==========================================
    public function storeMenu(Request $request) {
        $request->validate([
            'NAMA_MENU' => 'required',
            'HARGA_SATUAN' => 'required|numeric',
            'ID_KATEGORI' => 'required',
            'FOTO' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $namaFoto = null;
        if ($request->hasFile('FOTO')) {
            $file = $request->file('FOTO');
            $namaFoto = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/menu'), $namaFoto);
        }

        Menu::create([
            'ID_MENU' => 'M' . rand(1000, 9999),
            'ID_KATEGORI' => $request->ID_KATEGORI,
            'NAMA_MENU' => $request->NAMA_MENU,
            'HARGA_SATUAN' => $request->HARGA_SATUAN,
            'STATUS_TESEDIA' => 'tersedia',
            'FOTO' => $namaFoto
        ]);

        return redirect()->back()->with('success', 'Menu berhasil ditambahkan!');
    }

    public function updateMenu(Request $request, $id) {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'NAMA_MENU' => 'required',
            'HARGA_SATUAN' => 'required|numeric',
            'ID_KATEGORI' => 'required'
        ]);

        if ($request->hasFile('FOTO')) {
            $pathLama = public_path('images/menu/' . $menu->FOTO);
            if (file_exists($pathLama) && $menu->FOTO) { @unlink($pathLama); }

            $file = $request->file('FOTO');
            $namaFoto = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/menu'), $namaFoto);
            
            $menu->update(['FOTO' => $namaFoto]);
        }

        $menu->update([
            'NAMA_MENU' => $request->NAMA_MENU,
            'HARGA_SATUAN' => $request->HARGA_SATUAN,
            'ID_KATEGORI' => $request->ID_KATEGORI
        ]);

        return redirect()->back()->with('success', 'Menu berhasil diperbarui!');
    }

    // !!! PERBAIKAN UTAMA: HAPUS PAKSA (FORCE DELETE) !!!
    public function destroyMenu($id) {
        $menu = Menu::findOrFail($id);
        
        // 1. HAPUS FOTO
        $path = public_path('images/menu/' . $menu->FOTO);
        if (file_exists($path) && $menu->FOTO) { @unlink($path); }

        // 2. HAPUS RIWAYAT DETIL PEMESANAN YANG TERKAIT (SUPAYA BISA DIHAPUS)
        // Ini solusi untuk error Integrity constraint violation
        DB::table('detil_pemesanan')->where('ID_MENU', $id)->delete();

        // 3. HAPUS MENU
        $menu->delete();

        return redirect()->back()->with('success', 'Menu berhasil dihapus!');
    }

    public function updateMenuStatus($id) {
        $menu = Menu::findOrFail($id);
        $menu->update(['STATUS_TESEDIA' => $menu->STATUS_TESEDIA == 'tersedia' ? 'habis' : 'tersedia']);
        return redirect()->back();
    }

    // ==========================================
    // 5. FITUR LAINNYA & EXPORT EXCEL
    // ==========================================
    public function storeMeja(Request $request) {
        Meja::create(['ID_MEJA' => $request->ID_MEJA, 'STATUS_MEJA' => 'Kosong']);
        return redirect()->back();
    }

    public function directCustomerSession($id_meja) {
        $meja = Meja::where('ID_MEJA', $id_meja)->firstOrFail();
        session()->forget(['cart', 'last_order_id', 'customer_meja', 'customer_nama']); 
        session(['customer_meja' => $meja->ID_MEJA]);
        return redirect()->route('customer.menu');
    }

    public function customerIndex() {
        $daftarMenu = Menu::all(); 
        $id_meja = session('customer_meja');
        $riwayatPesanan = Pemesanan::where('ID_MEJA', $id_meja)
            ->where('STATUS_PESANAN', '!=', 'Selesai')
            ->with(['detail.menu', 'pembayaran'])->orderBy('ID_PESANAN', 'desc')->get();
        return view('customer.index', compact('daftarMenu', 'riwayatPesanan'));
    }

    public function addToCart($id) {
        if (!session()->has('customer_meja')) return redirect()->route('customer.direct', ['id_meja' => 'A1']);
        $menu = Menu::findOrFail($id);
        $cart = session()->get('cart', []);
        if(isset($cart[$id])) { $cart[$id]['quantity']++; } 
        else { $cart[$id] = ["name" => $menu->NAMA_MENU, "quantity" => 1, "price" => $menu->HARGA_SATUAN, "foto" => $menu->FOTO]; }
        session()->put('cart', $cart); return redirect()->back();
    }

    public function showCart() {
        $cart = session()->get('cart', []);
        $total = 0; foreach ($cart as $i) { $total += $i['price'] * $i['quantity']; }
        return view('customer.cart', compact('cart', 'total'));
    }

    public function removeFromCart($id) {
        $cart = session()->get('cart');
        if(isset($cart[$id])) { if($cart[$id]['quantity'] > 1) { $cart[$id]['quantity']--; } else { unset($cart[$id]); } session()->put('cart', $cart); }
        return redirect()->back();
    }

    public function increaseCart($id) {
        $cart = session()->get('cart');
        if(isset($cart[$id])) { $cart[$id]['quantity']++; session()->put('cart', $cart); }
        return redirect()->back();
    }

    public function logoutPelanggan() {
        session()->forget(['customer_nama', 'customer_phone', 'cart', 'last_order_id']);
        return redirect()->route('customer.menu');
    }

    public function cetakStruk($id) {
        $order = Pemesanan::with(['detail.menu', 'pembayaran'])->findOrFail($id);
        return view('kasir.struk', compact('order'));
    }

    // Export Excel CSV
    public function exportExcel(Request $request) {
        $tanggal = $request->get('tanggal', date('Y-m-d'));
        $fileName = 'Laporan_RielsCoffee_' . $tanggal . '.csv';

        // Fix RelationNotFoundException: hapus 'pembayaran.metode' dari with() jika relasi 'metode' tidak ada di model Pembayaran
        // Atau pastikan di Model Pembayaran ada public function metode() { return $this->belongsTo(MetodePembayaran::class, 'ID_METODE'); }
        // Di sini saya pakai query manual DB biar aman tanpa ubah Model
        
        $data = Pemesanan::where('STATUS_PESANAN', 'Selesai')
            ->whereHas('pembayaran', function($q) use ($tanggal) {
                $q->whereDate('WAKTU_PEMBAYARAN', $tanggal);
            })->with(['detail.menu', 'pembayaran']) // Hapus .metode jika error
            ->orderBy('ID_PESANAN', 'desc')->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No', 'Jam', 'ID Pesanan', 'Meja', 'Rincian Menu', 'Total Bayar (Rp)', 'Metode Bayar']);

            $no = 1;
            foreach ($data as $d) {
                $menuList = [];
                foreach($d->detail as $item) {
                    $namaMenu = $item->menu ? $item->menu->NAMA_MENU : 'Menu Terhapus';
                    $menuList[] = $namaMenu . " (" . $item->QTY . ")";
                }
                $menuString = implode(", ", $menuList);
                
                $jam = $d->pembayaran ? date('H:i', strtotime($d->pembayaran->WAKTU_PEMBAYARAN)) : '-';
                
                // Ambil Nama Metode Manual biar aman
                $namaMetode = 'Tunai';
                if($d->pembayaran) {
                    $metodeData = DB::table('metode_pembayaran')->where('ID_METODE', $d->pembayaran->ID_METODE)->first();
                    if($metodeData) $namaMetode = $metodeData->NAMA_METODE;
                }

                fputcsv($file, [
                    $no++, 
                    $jam, 
                    '#' . $d->ID_PESANAN, 
                    $d->ID_MEJA, 
                    $menuString, 
                    $d->TOTAL_BAYAR, 
                    $namaMetode
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
   
    public function cetakStrukDapur($id) {
      
        $order = \App\Models\Pemesanan::with(['detail.menu'])->findOrFail($id);
        
       
        return view('kasir.struk_dapur', compact('order'));
    }


}