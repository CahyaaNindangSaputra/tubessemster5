<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KasirController;

/*
|--------------------------------------------------------------------------
| Web Routes - RIELS COFFEE
|--------------------------------------------------------------------------
*/

// HALAMAN DEPAN (LANDING PAGE)
Route::get('/', function () { return view('welcome'); });

// ====================================================
// BAGIAN 1: KASIR (ADMIN / DASHBOARD)
// ====================================================
Route::prefix('kasir')->group(function () {
    
    // 1. Dashboard Utama
    Route::get('/', [KasirController::class, 'index'])->name('kasir.dashboard');

    // 2. Manajemen Meja
    Route::post('/meja/store', [KasirController::class, 'storeMeja'])->name('meja.store');

    // 3. Manajemen Menu (CRUD Lengkap)
    Route::post('/menu/store', [KasirController::class, 'storeMenu'])->name('menu.store');       // Tambah
    Route::put('/menu/update/{id}', [KasirController::class, 'updateMenu'])->name('menu.update'); // Edit
    Route::delete('/menu/delete/{id}', [KasirController::class, 'destroyMenu'])->name('menu.destroy'); // Hapus
    Route::patch('/menu/status/{id}', [KasirController::class, 'updateMenuStatus'])->name('menu.status'); // Stok Habis/Ada

    // 4. Proses Pesanan (Dapur & Bayar Tunai)
    Route::patch('/pesanan/status/{id}', [KasirController::class, 'updateStatus'])->name('pesanan.updateStatus');
    Route::post('/pesanan/bayar/{id}', [KasirController::class, 'prosesBayar'])->name('pesanan.bayar');

    // 5. Cetak Struk
    Route::get('/cetak-struk/{id}', [KasirController::class, 'cetakStruk'])->name('cetak.struk');
    Route::get('/export-laporan', [KasirController::class, 'exportExcel'])->name('kasir.export');
    // ... di dalam Route::prefix('kasir')->group(function () { ...

    // Route Cetak Struk Dapur (Khusus Koki)
    Route::get('/cetak-dapur/{id}', [KasirController::class, 'cetakStrukDapur'])->name('cetak.dapur');

// ...
});

// ====================================================
// BAGIAN 2: PELANGGAN (CUSTOMER ORDER DARI HP)
// ====================================================

// 1. Pintu Masuk (Scan QR Meja)
Route::get('/order/{id_meja}', [KasirController::class, 'directCustomerSession'])->name('customer.direct');

// 2. Halaman Menu Pelanggan
Route::get('/menu-pelanggan', [KasirController::class, 'customerIndex'])->name('customer.menu');

// 3. Fitur Keranjang Belanja
Route::prefix('cart')->group(function () {
    Route::get('/', [KasirController::class, 'showCart'])->name('cart.show');
    Route::post('/add/{id}', [KasirController::class, 'addToCart'])->name('cart.add');
    Route::delete('/remove/{id}', [KasirController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/increase/{id}', [KasirController::class, 'increaseCart'])->name('cart.increase');
    
    // Checkout (Hitung Total & Buat Pesanan)
    Route::post('/checkout', [KasirController::class, 'checkout'])->name('customer.checkout');
});

// 4. Pembayaran (Isi Nama & Pilih Metode)
Route::get('/pembayaran-pelanggan', [KasirController::class, 'showPaymentPage'])->name('customer.payment');
Route::post('/konfirmasi-pembayaran', [KasirController::class, 'confirmPayment'])->name('customer.payment.confirm');

// 5. Fitur Khusus QRIS (Scan Dulu Baru Lunas)
Route::get('/payment/qris/{id}', [KasirController::class, 'showQrisPage'])->name('customer.qris');
Route::post('/payment/qris/{id}/ok', [KasirController::class, 'markQrisPaid'])->name('customer.qris.confirm');

// 6. Ganti Pelanggan / Logout (Reset Sesi Nama)
Route::get('/ganti-pelanggan', [KasirController::class, 'logoutPelanggan'])->name('customer.logout');

