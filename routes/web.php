<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RegisController;
use App\Http\Controllers\OwnerController;
use App\Mail\EmailVerification;

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

// Auth Route
Route::post('/attempt-login', [WebController::class, 'attempt_login']);
Route::get('/check-this-user-role', [WebController::class, 'check_this_user_role']);
Route::get('/user-logout', [WebController::class, 'user_logout']);

// Account Regis Route
Route::get('/register', [RegisController::class, 'register']);
Route::get('/mail-check/{email}', [RegisController::class, 'mail_check']);
Route::post('/verification', [RegisController::class, 'verification']);
Route::get('/verification', function () {
    return redirect('/');
});
Route::get('/verification-resend/{id}', [RegisController::class, 'resend_code']);
Route::get('/verification-attempt/{id}', [RegisController::class, 'get_code']);
Route::post('/register-add', [RegisController::class, 'register_add']);

// Customer Route
Route::get('/', [WebController::class, 'index'])->name('index');
Route::get('/all-item', [WebController::class, 'all_item']);
Route::get('/get-keranjang-count', [WebController::class, 'keranjang_count']);
Route::get('/search-produk/{id}', [WebController::class, 'search_produk']);
Route::get('/produk-data/kitchen-set', [WebController::class, 'kitchen_set']);
Route::get('/produk-data/tempat-tidur', [WebController::class, 'tempat_tidur']);
Route::get('/produk-data/lemari', [WebController::class, 'lemari']);
Route::get('/produk-data/meja', [WebController::class, 'meja']);
Route::get('/produk-data/kursi', [WebController::class, 'kursi']);
Route::post('/produk/{id}', [WebController::class, 'view']);
Route::get('/produk/{id}', [WebController::class, 'view_get']);

Route::group(['middleware' => ['auth', 'customerRole']], function () {
    Route::get('/get-notifikasi', [WebController::class, 'get_notifikasi']);
    Route::get('/notifikasi-read', [WebController::class, 'notifikasi_read']);
    Route::get('/keranjang', [WebController::class, 'keranjang']);
    Route::get('/keranjang-data', [WebController::class, 'keranjang_data']);
    Route::get('/tambah-keranjang/{id}/{jumlah}', [WebController::class, 'tambah_keranjang']);
    Route::get('/keranjang-produk-update/{id}/{jumlah}', [WebController::class, 'keranjang_produk_update']);
    Route::get('/hapus-keranjang/{id}', [WebController::class, 'hapus_keranjang']);
    Route::get('/informasi-pesanan', [WebController::class, 'informasi_pesanan']);
    Route::post('/pesanan-proses', [WebController::class, 'pesanan_proses']);
    Route::get('/pesanan', [WebController::class, 'pesanan']);
    Route::get('/get-status-pesanan/{id}', [WebController::class, 'status_pesanan']);
    Route::get('/get-detail-harga/{id}', [WebController::class, 'detail_harga']);
    Route::get('/pesanan/{id}', [WebController::class, 'detail_pesanan']);
    Route::post('/upload-bukti-pembayaran', [WebController::class, 'upload_bukti_pembayaran']);
    Route::get('/pesanan/batal/{id}', [WebController::class, 'pesanan_batal']);
    Route::get('/pesanan/{id}/selesai', [WebController::class, 'pesanan_selesai']);
    Route::get('/pesanan/selesai/{id}', [WebController::class, 'selesai_pesanan']);
});



// Admin Route
Route::group(['middleware' => ['auth', 'adminRole']], function () {
    // Route::get('/admin', function(){
    //     return view('admin.dashboard');
    // });
    Route::get('/admin/notification-badge', [AdminController::class, 'notification_badge']);
    Route::get('/admin/produk', [AdminController::class, 'produk']);
    Route::get('/admin/produk-data', [AdminController::class, 'produk_data']);
    Route::post('/admin/tambah-produk', [AdminController::class, 'tambah_produk']);
    Route::post('/admin/update-produk/{id}', [AdminController::class, 'update_produk']);
    Route::get('/admin/delete-produk/{id}', [AdminController::class, 'delete_produk']);
    Route::get('/cari-produk/{id}', [AdminController::class, 'cari_produk']);
    Route::get('/admin/produk-data/kitchen-set', [AdminController::class, 'kitchen_set']);
    Route::get('/admin/produk-data/tempat-tidur', [AdminController::class, 'tempat_tidur']);
    Route::get('/admin/produk-data/lemari', [AdminController::class, 'lemari']);
    Route::get('/admin/produk-data/meja', [AdminController::class, 'meja']);
    Route::get('/admin/produk-data/kursi', [AdminController::class, 'kursi']);

    // Pesanan
    Route::get('/admin/pesanan/menunggu-konfirmasi', [AdminController::class, 'menunggu_konfirmasi']);
    Route::get('/admin/pesanan/menunggu-konfirmasi-data', [AdminController::class, 'menunggu_konfirmasi_data']);
    Route::post('/admin/pesanan/konfirmasi/{id}', [AdminController::class, 'konfirmasi_pesanan']);
    Route::post('/admin/pesanan/batal', [AdminController::class, 'batal_pesanan']);

    Route::get('/admin/pesanan/validasi-pembayaran', [AdminController::class, 'validasi_pembayaran']);
    Route::get('/admin/pesanan/validasi-pembayaran-data', [AdminController::class, 'validasi_pembayaran_data']);
    Route::get('/admin/pesanan/valid/{id}', [AdminController::class, 'pembayaran_valid']);
    Route::get('/admin/pesanan/invalid/{id}', [AdminController::class, 'pembayaran_invalid']);

    Route::get('/admin/pesanan/pengiriman', [AdminController::class, 'pengiriman']);
    Route::get('/admin/pesanan/antar/{id}', [AdminController::class, 'antar']);

    Route::get('/admin/pesanan/konfirmasi-tiba-di-tujuan', [AdminController::class, 'konfirmasi_tiba_di_tujuan']);
    Route::get('/admin/pesanan/tiba-di-tujuan/{id}', [AdminController::class, 'tiba_di_tujuan']);

    Route::get('/admin/semua-transaksi', [AdminController::class, 'semua_transaksi']);
    Route::get('/admin/detail-pesanan/{id}', [AdminController::class, 'detail_pesanan']);
    Route::get('/admin/semua-transaksi-data', [AdminController::class, 'semua_transaksi_data']);
    Route::get('/admin/cari-pesanan/{id}', [AdminController::class, 'cari_pesanan']);
});

// Owner Route
Route::group(['middleware' => ['auth', 'ownerRole']], function () {
    Route::get('/owner', [OwnerController::class, 'dashboard']);
    Route::get('/owner/produk-data', [OwnerController::class, 'produk_data']);
    Route::get('/owner/produk-data/kitchen-set', [OwnerController::class, 'kitchen_set']);
    Route::get('/owner/produk-data/tempat-tidur', [OwnerController::class, 'tempat_tidur']);
    Route::get('/owner/produk-data/lemari', [OwnerController::class, 'lemari']);
    Route::get('/owner/produk-data/meja', [OwnerController::class, 'meja']);
    Route::get('/owner/produk-data/kursi', [OwnerController::class, 'kursi']);
    Route::get('/owner/cari-produk/{id}', [OwnerController::class, 'cari_produk']);
    Route::get('/owner/detail-pesanan/{id}', [OwnerController::class, 'detail_pesanan']);
    Route::get('/owner/semua-transaksi', [OwnerController::class, 'semua_transaksi']);
    Route::get('/owner/semua-transaksi-data', [OwnerController::class, 'semua_transaksi_data']);
    Route::get('/owner/cari-pesanan/{id}', [OwnerController::class, 'cari_pesanan']);
});
