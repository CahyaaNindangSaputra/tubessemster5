<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ResepController; // <--- WAJIB ADA INI
use App\Http\Controllers\DapurController;



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
    Route::post('/kasir/selesai/{id}', [KasirController::class, 'selesaikanPesanan'])->name('kasir.selesai');

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


Route::get('/resep/tambah', [ResepController::class, 'create'])->name('resep.create');
Route::post('/resep/store', [ResepController::class, 'store'])->name('resep.store');



Route::get('/supplier/stok', [SupplierController::class, 'index'])->name('supplier.index');
Route::post('/supplier/stok/store', [SupplierController::class, 'store'])->name('supplier.store');
    // Tambahkan baris ini di routes/web.php
Route::get('/supplier/dashboard', [SupplierController::class, 'dashboard'])->name('supplier.dashboard');



// Route untuk melihat halaman dapur (Tampilan koki)
Route::get('/dapur', [DapurController::class, 'index'])->name('dapur.index');

// Route untuk tombol "Mulai Masak" (Proses pengurangan stok & update status)
Route::post('/dapur/masak/{id}', [DapurController::class, 'masak'])->name('dapur.masak');


// Pastikan rute ini ada
Route::post('/dapur/update-status/{id}', [DapurController::class, 'updateStatus'])->name('dapur.updateStatus');
Route::post('/kasir/kirim-dapur/{id}', [KasirController::class, 'kirimKeDapur'])->name('kasir.kirimDapur');


// Tambahkan rute ini di dalam routes/web.php
Route::post('/supplier/bahan/simpan', [SupplierController::class, 'storeBahan'])->name('supplier.storeBahan');
Route::post('/supplier/bahan/simpan', [SupplierController::class, 'storeBahan'])->name('supplier.storeBahan');
Route::delete('/supplier/bahan/hapus/{id}', [SupplierController::class, 'destroyBahan'])->name('supplier.destroyBahan');
Route::put('/supplier/bahan/restock/{id}', [SupplierController::class, 'restockBahan'])->name('supplier.restockBahan');
Route::put('/supplier/bahan/keluar/{id}', [SupplierController::class, 'keluarBahan'])->name('supplier.keluarBahan');
Route::get('/supplier/export-excel', [SupplierController::class, 'exportExcel'])->name('supplier.exportExcel');


// Rute untuk cetak semua antrean dan mengubah status ke 'Dimasak'
Route::get('/dapur/cetak-semua', [KasirController::class, 'cetakSemuaAntrean'])->name('cetak.semua.antrean');

// Rute Manajemen Resep di Dapur
Route::get('/dapur/resep', [ResepController::class, 'index'])->name('dapur.resep.index');
Route::get('/dapur/resep/tambah', [ResepController::class, 'create'])->name('dapur.resep.tambah');
Route::post('/dapur/resep', [ResepController::class, 'store'])->name('dapur.resep.store');
/* Route::delete('/dapur/resep/{id}', [ResepController::class, 'destroy'])->name('dapur.resep.destroy'); */
Route::delete('/dapur/resep/{id}', [App\Http\Controllers\ResepController::class, 'destroy'])->name('dapur.resep.destroy');
Route::get('/dapur/resep/{id}/edit', [App\Http\Controllers\ResepController::class, 'edit'])->name('dapur.resep.edit');
Route::put('/dapur/resep/{id}', [App\Http\Controllers\ResepController::class, 'update'])->name('dapur.resep.update');