<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use App\Models\Menu;
use App\Models\Pemesanan;
use App\Models\Pelanggan;
use App\Models\Resep;
use App\Models\Stokbahan;
use App\Models\DetilPemesanan;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    // Fungsi bantuan untuk memotong stok bahan baku gudang otomatis dengan aman dan anti-double
    private function potongStok($id_pesanan) {
        $cacheKey = 'stok_dipotong_' . $id_pesanan;
        
        // Cegah agar fungsi tidak tereksekusi 2x dalam 1 pesanan yang sama
        if (session()->has($cacheKey)) {
            return;
        }
    
        // Ambil semua detail menu dari pesanan ini
        $detilPesanan = DetilPemesanan::where('ID_PESANAN', $id_pesanan)->get();
        
        foreach ($detilPesanan as $detil) {
            // Ambil resep berdasarkan ID_MENU yang dipesan
            $reseps = Resep::where('ID_MENU', $detil->ID_MENU)->get();
            
            foreach ($reseps as $resep) {
                $stok = Stokbahan::find($resep->ID_BAHAN_STOK);
                
                if ($stok) {
                    // Hitung total pengurangan: jumlah kebutuhan resep x jumlah beli (QTY)
                    $totalPengurangan = (float)$resep->JUMLAH_KEBUTUHAN * (int)$detil->QTY;
                    
                    // Pastikan nilai stok saat ini dikurangi dengan benar dan tidak pernah tembus di bawah 0
                    $stok->JUMLAH_BAHAN = max(0, (float)$stok->JUMLAH_BAHAN - $totalPengurangan);
                    
                    $stok->save();
                }
            }
        }
    
        // Tandai pesanan ini sudah dipotong stoknya di session
        session()->put($cacheKey, true);
    }

    public function index(Request $request) {
        date_default_timezone_set('Asia/Jakarta');
        $tanggalFilter = $request->get('tanggal', date('Y-m-d'));
        
        $mejaTerisi = \App\Models\Pemesanan::where('STATUS_PESANAN', '!=', 'Selesai')
                ->pluck('ID_MEJA')
                ->unique()
                ->toArray();
    
        $menungguBayar = Pemesanan::where('STATUS_PESANAN', 'Menunggu')->get();
        $sedangProses = Pemesanan::whereIn('STATUS_PESANAN', ['Antre', 'Proses', 'Dimasak', 'Siap'])->get();
    
        $riwayatSelesai = Pemesanan::where('STATUS_PESANAN', 'Selesai')
            ->whereHas('pembayaran', function($query) use ($tanggalFilter) {
                $query->whereDate('WAKTU_PEMBAYARAN', $tanggalFilter);
            })->with(['detail.menu', 'pembayaran'])->latest('ID_PESANAN')->get();
    
        $daftarMeja = Meja::all();
        $daftarMenu = Menu::all();
        metodeBayar: $metodeBayar = DB::table('metode_pembayaran')->get(); 
    
        return view('kasir.dashboard', compact(
            'daftarMeja', 'mejaTerisi', 'menungguBayar', 'sedangProses', 
            'riwayatSelesai', 'tanggalFilter', 'daftarMenu', 'metodeBayar'
        ));
    }

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
                'ID_PESANAN' => $id_pesanan, 
                'ID_MENU' => $id_menu,
                'QTY' => $d['quantity'], 
                'SUBTOTAL' => $d['price'] * $d['quantity']
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
            // Potong stok otomatis untuk pembayaran tunai langsung
            $this->potongStok($id_pesanan);

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
        $sudahBayar = DB::table('pembayaran')->where('ID_PESANAN', $id)->first();
        if ($sudahBayar) {
            return redirect()->route('customer.menu')
                ->with('success', 'Pembayaran ini sudah pernah diproses sebelumnya!');
        }
    
        $id_metode = session('temp_id_metode'); 
        
        // Potong stok otomatis saat pembayaran QRIS divalidasi lunas
        $this->potongStok($id);
    
        DB::table('pemesanan')->where('ID_PESANAN', $id)
            ->update(['STATUS_PESANAN' => 'Proses']); 
        
        do {
            $id_pembayaran = 'B' . rand(1000, 9999);
            $cekDuplikat = DB::table('pembayaran')->where('ID_PEMBAYARAN', $id_pembayaran)->exists();
        } while ($cekDuplikat);
    
        DB::table('pembayaran')->insert([
            'ID_PEMBAYARAN'     => $id_pembayaran,
            'ID_PESANAN'        => $id,
            'ID_METODE'         => $id_metode,
            'STATUS_PEMBAYARAN' => 'Lunas',
            'WAKTU_PEMBAYARAN'  => now()
        ]);
    
        session()->forget(['last_order_id', 'temp_id_metode']);
    
        return redirect()->route('customer.menu')
            ->with('success', 'Pembayaran QRIS Berhasil! Pesanan langsung masuk ke Dapur.');
    }

    public function prosesBayar(Request $request, $id) {
        if (!$request->id_metode) {
            return redirect()->back()->with('error', 'PILIH METODE BAYAR DULU BOSS!');
        }
    
        // Potong stok otomatis saat pembayaran kasir diproses
        $this->potongStok($id);
    
        DB::table('pemesanan')->where('ID_PESANAN', $id)->update(['STATUS_PESANAN' => 'Antre']);
    
        DB::table('pembayaran')->insert([
            'ID_PEMBAYARAN'     => 'B' . rand(1000, 9999),
            'ID_PESANAN'        => $id,
            'ID_METODE'         => $request->id_metode,
            'STATUS_PEMBAYARAN' => 'Lunas', 
            'WAKTU_PEMBAYARAN'  => now()
        ]);
    
        return redirect()->back()->with('success', 'SUKSES! Masuk Antrean Dapur.');
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

    public function destroyMenu($id) {
        $menu = Menu::findOrFail($id);
        
        $path = public_path('images/menu/' . $menu->FOTO);
        if (file_exists($path) && $menu->FOTO) { @unlink($path); }

        DB::table('detil_pemesanan')->where('ID_MENU', $id)->delete();
        $menu->delete();

        return redirect()->back()->with('success', 'Menu berhasil dihapus!');
    }

    public function updateMenuStatus($id) {
        $menu = Menu::findOrFail($id);
        $menu->update(['STATUS_TESEDIA' => $menu->STATUS_TESEDIA == 'tersedia' ? 'habis' : 'tersedia']);
        return redirect()->back();
    }

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

    public function exportExcel(Request $request) {
        $tanggal = $request->get('tanggal', date('Y-m-d'));
        $fileName = 'Laporan_RielsCoffee_' . $tanggal . '.csv';
        
        $data = Pemesanan::where('STATUS_PESANAN', 'Selesai')
            ->whereHas('pembayaran', function($q) use ($tanggal) {
                $q->whereDate('WAKTU_PEMBAYARAN', $tanggal);
            })->with(['detail.menu', 'pembayaran'])
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
                
                $namaMetode = 'Tunai';
                if($d->pembayaran) {
                    $metodeData = DB::table('metode_pembayaran')->where('ID_METODE', $d->pembayaran->ID_METODE)->first();
                    if($metodeData) $namaMetode = $metodeData->NAMA_METODE;
                }

                fputcsv($file, [
                    $no++, $jam, '#' . $d->ID_PESANAN, $d->ID_MEJA, $menuString, $d->TOTAL_BAYAR, $namaMetode
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
    
    public function cetakStrukDapur($id) {
        $order = \App\Models\Pemesanan::with(['detail.menu'])->findOrFail($id);
        
        if ($order->STATUS_PESANAN == 'Antre') {
            $order->update(['STATUS_PESANAN' => 'Dimasak']);
        }
    
        return view('kasir.struk_dapur', compact('order'));
    }
    
    public function selesaikanPesanan($id_pesanan) {
        Pemesanan::where('ID_PESANAN', $id_pesanan)->update(['STATUS_PESANAN' => 'Selesai']);
        return redirect()->back()->with('success', 'Pesanan selesai!');
    }

    public function kirimKeDapur($id) {
        Pemesanan::where('ID_PESANAN', $id)->update(['STATUS_PESANAN' => 'Antre']);
        return redirect()->back()->with('success', 'Pesanan masuk antrean dapur!');
    } 

    public function cetakSemuaAntrean() {
        $pesananAntre = \App\Models\Pemesanan::where('STATUS_PESANAN', 'Antre')->get();
        \App\Models\Pemesanan::where('STATUS_PESANAN', 'Antre')->update(['STATUS_PESANAN' => 'Dimasak']);
        return view('kasir.struk_semua_antrean', compact('pesananAntre'));
    }
}