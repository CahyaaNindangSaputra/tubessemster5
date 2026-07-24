<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ResepController;
use App\Http\Controllers\DapurController;

/*
|--------------------------------------------------------------------------
| Web Routes - RIELS COFFEE
|--------------------------------------------------------------------------
*/

// HALAMAN DEPAN (LANDING PAGE)
Route::get('/', function () { 
    return view('welcome'); 
});

// ====================================================
// 1. BAGIAN KASIR (ADMIN / DASHBOARD)
// ====================================================
Route::prefix('kasir')->group(function () {
    Route::get('/', [KasirController::class, 'index'])->name('kasir.dashboard');
    Route::post('/selesai/{id}', [KasirController::class, 'selesaikanPesanan'])->name('kasir.selesai');

    // Manajemen Meja
    Route::post('/meja/store', [KasirController::class, 'storeMeja'])->name('meja.store');

    // Manajemen Menu (CRUD Lengkap)
    Route::post('/menu/store', [KasirController::class, 'storeMenu'])->name('menu.store');         // Tambah
    Route::put('/menu/update/{id}', [KasirController::class, 'updateMenu'])->name('menu.update'); // Edit
    Route::delete('/menu/delete/{id}', [KasirController::class, 'destroyMenu'])->name('menu.destroy'); // Hapus
    Route::patch('/menu/status/{id}', [KasirController::class, 'updateMenuStatus'])->name('menu.status'); // Stok Habis/Ada

    // Proses Pesanan & Pembayaran
    Route::patch('/pesanan/status/{id}', [KasirController::class, 'updateStatus'])->name('pesanan.updateStatus');
    Route::post('/pesanan/bayar/{id}', [KasirController::class, 'prosesBayar'])->name('pesanan.bayar');
    Route::post('/kirim-dapur/{id}', [KasirController::class, 'kirimKeDapur'])->name('kasir.kirimDapur');

    // Cetak Struk & Laporan
    Route::get('/cetak-struk/{id}', [KasirController::class, 'cetakStruk'])->name('cetak.struk');
    Route::get('/cetak-dapur/{id}', [KasirController::class, 'cetakStrukDapur'])->name('cetak.dapur');
    Route::get('/export-laporan', [KasirController::class, 'exportExcel'])->name('kasir.export');
});

// ====================================================
// 2. BAGIAN PELANGGAN (CUSTOMER ORDER DARI HP)
// ====================================================
Route::get('/order/{id_meja}', [KasirController::class, 'directCustomerSession'])->name('customer.direct');
Route::get('/menu-pelanggan', [KasirController::class, 'customerIndex'])->name('customer.menu');

// Fitur Keranjang Belanja
Route::prefix('cart')->group(function () {
    Route::get('/', [KasirController::class, 'showCart'])->name('cart.show');
    Route::post('/add/{id}', [KasirController::class, 'addToCart'])->name('cart.add');
    Route::delete('/remove/{id}', [KasirController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/increase/{id}', [KasirController::class, 'increaseCart'])->name('cart.increase');
    Route::post('/checkout', [KasirController::class, 'checkout'])->name('customer.checkout');
});

// Pembayaran Pelanggan & QRIS
Route::get('/pembayaran-pelanggan', [KasirController::class, 'showPaymentPage'])->name('customer.payment');
Route::post('/konfirmasi-pembayaran', [KasirController::class, 'confirmPayment'])->name('customer.payment.confirm');
Route::get('/payment/qris/{id}', [KasirController::class, 'showQrisPage'])->name('customer.qris');
Route::post('/payment/qris/{id}/ok', [KasirController::class, 'markQrisPaid'])->name('customer.qris.confirm');

// Logout / Ganti Pelanggan
Route::get('/ganti-pelanggan', [KasirController::class, 'logoutPelanggan'])->name('customer.logout');

// ====================================================
// 3. BAGIAN SUPPLIER & MANAJEMEN STOK GUDANG
// ====================================================
Route::prefix('supplier')->group(function () {
    Route::get('/dashboard', [SupplierController::class, 'dashboard'])->name('supplier.dashboard');
    Route::get('/stok', [SupplierController::class, 'index'])->name('supplier.index');
    Route::post('/stok/store', [SupplierController::class, 'store'])->name('supplier.store');
    
    // Kelola Bahan Baku
    Route::post('/bahan/simpan', [SupplierController::class, 'storeBahan'])->name('supplier.storeBahan');
    Route::delete('/bahan/hapus/{id}', [SupplierController::class, 'destroyBahan'])->name('supplier.destroyBahan');
    Route::put('/bahan/restock/{id}', [SupplierController::class, 'restockBahan'])->name('supplier.restockBahan');
    Route::put('/bahan/keluar/{id}', [SupplierController::class, 'keluarBahan'])->name('supplier.keluarBahan');
    Route::get('/export-excel', [SupplierController::class, 'exportExcel'])->name('supplier.exportExcel');
});

// ====================================================
// 4. BAGIAN DAPUR & KOKI
// ====================================================
Route::prefix('dapur')->group(function () {
    Route::get('/', [DapurController::class, 'index'])->name('dapur.index');
    Route::post('/masak/{id}', [DapurController::class, 'masak'])->name('dapur.masak');
    Route::post('/update-status/{id}', [DapurController::class, 'updateStatus'])->name('dapur.updateStatus');
    Route::get('/cetak-semua', [KasirController::class, 'cetakSemuaAntrean'])->name('cetak.semua.antrean');
});

// ====================================================
// 5. BAGIAN MANAJEMEN RESEP
// ====================================================
Route::prefix('resep')->group(function () {
    Route::get('/tambah', [ResepController::class, 'create'])->name('resep.create');
    Route::post('/store', [ResepController::class, 'store'])->name('resep.store');
});

Route::prefix('dapur/resep')->group(function () {
    Route::get('/', [ResepController::class, 'index'])->name('dapur.resep.index');
    Route::get('/tambah', [ResepController::class, 'create'])->name('dapur.resep.tambah'); // Atau diletakkan di /resep/tambah
    Route::post('/', [ResepController::class, 'store'])->name('dapur.resep.store');
    Route::get('/{id}/edit', [ResepController::class, 'edit'])->name('dapur.resep.edit');
    Route::put('/{id}', [ResepController::class, 'update'])->name('dapur.resep.update');
    Route::delete('/{id}', [ResepController::class, 'destroy'])->name('dapur.resep.destroy');
});