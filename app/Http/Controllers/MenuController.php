<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
   
public function index()
{
    
    $daftarMenu = \App\Models\Menu::all();
    
    
    $categories = [
        'makanan' => 'K01',
        'minuman' => 'K02',
        'snack'   => 'K03'
    ];

  
    return view('customer.index', compact('daftarMenu', 'categories'));
}



public function confirmPayment(Request $request) {
   
    $id_pesanan = session('last_order_id');
    $id_metode = $request->id_metode;

    if (!$id_pesanan) {
        return redirect()->route('customer.menu')->with('error', 'Sesi pesanan habis.');
    }

    //
    \Illuminate\Support\Facades\DB::table('pemesanan')
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
    $metodeBayar = \Illuminate\Support\Facades\DB::table('metode_pembayaran')->get();

    
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
}