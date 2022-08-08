<?php

use App\Http\Controllers\{
    HomeController,
    KategoriController,
    LaporanController,
    MemberController,
    PembelianController,
    PembelianDetailController,
    PengeluaranController,
    PenjualanController,
    ProdukController,
    SettingController,
    SupplierController,
    UserController,
};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
    'confirm' => false
]);

Route::get('/', function () {
    return redirect()->route('login');
});

Route::group(['middleware' => 'auth'], function () {

    Route::group(['middleware' => ['role:admin']], function () {
        Route::post('user/destroyBatch', [UserController::class, 'destroyBatch'])->name('user.destroy.batch');
        Route::resource('user', UserController::class)->except('create', 'show');

        Route::post('kategori/destroyBatch', [KategoriController::class, 'destroyBatch'])->name('kategori.destroy.batch');
        Route::resource('kategori', KategoriController::class)->except('create', 'show');

        Route::post('produk/cetakBarcode', [ProdukController::class, 'cetakBarcode'])->name('produk.cetak.barcode');
        Route::get('produk/stokLimit', [ProdukController::class, 'stokLimit'])->name('produk.stok.limit');
        Route::post('produk/destroyBatch', [ProdukController::class, 'destroyBatch'])->name('produk.destroy.batch');
        Route::resource('produk', ProdukController::class)->except('create', 'show');

        Route::post('member/destroyBatch', [MemberController::class, 'destroyBatch'])->name('member.destroy.batch');
        Route::resource('member', MemberController::class)->except('create', 'show');

        Route::post('supplier/destroyBatch', [SupplierController::class, 'destroyBatch'])->name('supplier.destroy.batch');
        Route::resource('supplier', SupplierController::class)->except('create', 'show');

        Route::post('pengeluaran/destroyBatch', [PengeluaranController::class, 'destroyBatch'])->name('pengeluaran.destroy.batch');
        Route::resource('pengeluaran', PengeluaranController::class)->except('create', 'show');

        Route::post('pembelian/destroyBatch', [PembelianController::class, 'destroyBatch'])->name('pembelian.destroy.batch');
        Route::resource('pembelian', PembelianController::class)->except('update', 'show');

        Route::get('penjualan/{penjualan}/print', [PenjualanController::class, 'print'])->name('penjualan.print');
        Route::post('penjualan/destroyBatch', [PenjualanController::class, 'destroyBatch'])->name('penjualan.destroy.batch');
        Route::resource('penjualan', PenjualanController::class)->except('update', 'show');

        Route::get('/setting', [SettingController::class, 'index'])->name('setting.toko');
        Route::post('/setting', [SettingController::class, 'update'])->name('setting.toko.update');

        Route::get('/laporan/pendapatan', [LaporanController::class, 'index'])->name('laporan.pendapatan');
        Route::get('/laporan/kasir', [LaporanController::class, 'kasir'])->name('laporan.kasir');
        Route::get('/laporan/supplier', [LaporanController::class, 'supplier'])->name('laporan.supplier');
        Route::get('/laporan/perbulan', [LaporanController::class, 'bulan'])->name('laporan.perbulan');
    });
    // Route::group(['middleware' => ['role:kasir']], function () {

    // });

    Route::group(['middleware' => ['role:admin|kasir']], function () {
        Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

        Route::get('/profile', [SettingController::class, 'profile'])->name('setting.profile');
        Route::post('/profile', [SettingController::class, 'profileUpdate'])->name('setting.profileUpdate');

        Route::resource('produk', ProdukController::class)->only('index');
        Route::resource('member', MemberController::class)->only('store', 'index');

        Route::get('/laporan/penjualanKasir', [LaporanController::class, 'penjualanKasir'])->name('laporan.penjualan.kasir');
        Route::get('/penjualan/printLast', [PenjualanController::class, 'penjualanPrintLast'])->name('penjualan.print.last');
        Route::resource('penjualan', PenjualanController::class)->only('create', 'store');
    });
});



// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
