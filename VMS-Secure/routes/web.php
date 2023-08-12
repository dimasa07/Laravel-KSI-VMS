<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FrontOfficeController;
use App\Http\Controllers\TamuController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\FrontOfficeMiddleware;
use App\Http\Middleware\TamuMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::get('/', function (Request $request) {
    $request->session()->flush();
    return view('beranda');
})->name('beranda');
Route::get('/visi-misi', function () {
    return view('visi_misi');
})->name('visi-misi');
Route::get('/struktur-organisasi', function () {
    return view('struktur_organisasi');
})->name('struktur-organisasi');
Route::get('/bidang-aptika', function () {
    return view('bidang_aptika');
})->name('layanan.bidang-aptika');
Route::get('/bidang-tik', function () {
    return view('bidang_tik');
})->name('layanan.bidang-tik');
Route::get('/bidang-ikp', function () {
    return view('bidang_ikp');
})->name('layanan.bidang-ikp');
Route::get('/bidang-statistik', function () {
    return view('bidang_statistik');
})->name('layanan.bidang-statistik');
Route::get('/bidang-keamanan-persandian', function () {
    return view('bidang_keamanan_persandian');
})->name('layanan.bidang-keamanan-persandian');

// USER AUTHENTICATED
Route::prefix('/user')
    ->controller(UserController::class)
    ->middleware(AdminMiddleware::class)
    ->group(function () {
        Route::get('/all', 'allUser')->name('user.all');
        Route::get('/get/username/{username}', 'getByUsername')->name('user.get.username');
        Route::get('/get/tamu/id/{id}', 'getTamuById')->name('user.get.tamu.id');
        Route::get('/get/tamu/nik/{nik}', 'getTamuByNIK')->name('user.get.tamu.nik');
        Route::get('/get/tamu/nama/{nama}', 'getTamuByNama')->name('user.get.tamu.nama');
        Route::get('/get/pegawai/id/{id}', 'getPegawaiById')->name('user.get.pegawai.id');
        Route::get('/get/pegawai/nip/{nip}', 'getPegawaiByNIP')->name('user.get.pegawai.nip');
        Route::get('/get/pegawai/nama/{nama}', 'getPegawaiByNama')->name('user.get.pegawai.nama');
        Route::get('/get/role/{role}', 'getByRole')->name('user.get.role');
        Route::post('/admin/update', 'updateAdmin')->name('user.admin.update');
        Route::get('/admin/delete/{id}', 'deleteAdmin')->name('user.admin.delete');
        Route::post('/akun/update', 'updateAkun')->name('user.akun.update');
        Route::get('/akun/delete/{id}', 'deleteAkun')->name('user.akun.delete');
        Route::post('/tamu/update', 'updateTamu')->name('user.tamu.update');
        Route::get('/tamu/delete/{id}', 'deleteTamu')->name('user.tamu.delete');
        Route::post('/fo/update', 'updateFrontOffice')->name('user.fo.update');
        Route::get('/fo/delete/{id}', 'deleteFrontOffice')->name('user.fo.delete');
        Route::post('/pegawai/update', 'updatePegawai')->name('user.pegawai.update');
        Route::get('/pegawai/delete/{id}', 'deletePegawai')->name('user.pegawai.delete');
    });

// USER ROUTES
Route::prefix('/user')
    ->controller(UserController::class)
    ->group(function () {
        Route::get('/daftar', 'formDaftar')->name('user.form.daftar');
        Route::post('/daftar', 'daftar')->name('user.daftar');
        Route::get('/login', 'formLogin')->name('user.form.login');
        Route::post('/login', 'login')->name('user.login');
        Route::get('/logout', 'logout')->name('user.logout');
    });

// ADMIN ROUTES
Route::prefix('/admin')
    ->controller(AdminController::class)
    ->middleware(AdminMiddleware::class)
    ->group(function () {
        Route::get('/', 'index')->name('admin.index');
        Route::get('/profil', 'profil')->name('admin.profil');
        Route::post('/profil/update', 'updateProfil')->name('admin.profil.update');
        Route::get('/akun', 'akun')->name('admin.akun');
        Route::post('/akun/update', 'updateAkun')->name('admin.akun.update');
        Route::get('/permintaan/all', 'allPermintaanBertamu')->name('admin.permintaan.all');
        Route::get('/permintaan/setujui/{idPermintaan}', 'setujuiPermintaan')->name('admin.permintaan.setujui');
        Route::post('/permintaan/tolak', 'tolakPermintaan')->name('admin.permintaan.tolak');
        Route::get('/all', 'allAdmin')->name('admin.all');
        Route::get('/pegawai/all', 'allPegawai')->name('admin.pegawai.all');
        Route::get('/fo/all', 'allFrontOffice')->name('admin.fo.all');
        Route::get('/tamu/all', 'allTamu')->name('admin.tamu.all');
        Route::get('/tamu/delete/{id}', 'deleteTamu')->name('admin.tamu.delete');
        Route::get('/buku-tamu/all', 'allBukuTamu')->name('admin.buku-tamu.all');
        Route::get('/buku-tamu/delete/{id}', 'deleteBukuTamu')->name('admin.buku-tamu.delete');
        Route::get('/buku-tamu/cetak/{filter}', 'cetakBukuTamu')->name('admin.buku-tamu.cetak');
        Route::get('/tamu/get/nik/{nik}', 'getTamuByNIK')->name('admin.tamu.get.nik');
        Route::post('/pegawai/tambah', 'tambahPegawai')->name('admin.pegawai.tambah');
        Route::post('/pegawai/update', 'updatePegawai')->name('admin.pegawai.update');
        Route::get('/pegawai/delete/{id}', 'deletePegawai')->name('admin.pegawai.delete');
        Route::post('/tambah', 'tambahAdmin')->name('admin.tambah');
    });

// TAMU ROUTES 
Route::prefix('/tamu')
    ->controller(TamuController::class)
    ->middleware(TamuMiddleware::class)
    ->group(function () {
        Route::get('/', 'index')->name('tamu.index');
        Route::get('/profil', 'profil')->name('tamu.profil');
        Route::post('/profil/update', 'updateProfil')->name('tamu.profil.update');
        Route::get('/akun', 'akun')->name('tamu.akun');
        Route::post('/akun/update', 'updateAkun')->name('tamu.akun.update');
        Route::get('/akun/delete', 'deleteAkun')->name('tamu.akun.delete');
        Route::post('/permintaan/tambah', 'tambahPermintaan')->name('tamu.permintaan.tambah');
        Route::get('/permintaan/buat', 'viewBuatPermintaan')->name('tamu.permintaan.buat');
        Route::get('/permintaan/all/{idTamu}', 'allPermintaanBertamu')->name('tamu.permintaan.all');
        Route::post('/permintaan/update', 'updatePermintaanBertamu')->name('tamu.permintaan.update');
        Route::get('/permintaan/delete/{id}', 'deletePermintaanBertamu')->name('tamu.permintaan.delete');
        Route::get('/riwayat/permintaan', 'riwayatPermintaan')->name('tamu.riwayat.permintaan');
        Route::get('/riwayat/bertamu', 'riwayatBertamu')->name('tamu.riwayat.bertamu');
    });

// FRONT OFFICE ROUTES
Route::prefix('/fo')
    ->controller(FrontOfficeController::class)
    ->middleware(FrontOfficeMiddleware::class)
    ->group(function () {
        Route::get('/', 'index')->name('fo.index');
        Route::get('/profil', 'profil')->name('fo.profil');
        Route::post('/profil/update', 'updateProfil')->name('fo.profil.update');
        Route::get('/akun', 'akun')->name('fo.akun');
        Route::post('/akun/update', 'updateAkun')->name('fo.akun.update');
        Route::get('/tamu/all', 'allTamu')->name('fo.tamu.all');
        Route::get('/permintaan/all', 'allPermintaanBertamu')->name('fo.permintaan.all');
        Route::post('/permintaan/tambah', 'tambahPermintaan')->name('fo.permintaan.tambah');
        Route::get('/permintaan/buat', 'viewBuatPermintaan')->name('fo.permintaan.buat');
        Route::post('/permintaan/update', 'updatePermintaanBertamu')->name('fo.permintaan.update');
        Route::get('/permintaan/delete/{id}', 'deletePermintaanBertamu')->name('fo.permintaan.delete');
        Route::get('/check-in', 'viewCheckIn')->name('fo.check-in');
        Route::get('/check-out', 'viewCheckOut')->name('fo.check-out');
        Route::get('/buku-tamu/check-in/{id}', 'checkIn')->name('fo.buku-tamu.check-in');
        Route::get('/buku-tamu/check-out/{id}', 'checkOut')->name('fo.buku-tamu.check-out');
        Route::get('/buku-tamu/all', 'allBukuTamu')->name('fo.buku-tamu.all');
        Route::get('/buku-tamu/cetak/{filter}', 'cetakBukuTamu')->name('fo.buku-tamu.cetak');
        Route::get('/buku-tamu/delete/{id}', 'deleteBukuTamu')->name('fo.buku-tamu.delete');
    });
