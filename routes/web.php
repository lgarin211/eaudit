<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OPD\Fe\DashboardOPD;
use App\Http\Controllers\FE\DashboardTLController;
use App\Http\Controllers\AdminTL\UserControlController;
// use App\Http\Controllers\ObrikTL\DashboardObrikTLController;
// use App\Http\Controllers\PemeriksaTL\DashboardPemeriksaTLController;
use App\Http\Controllers\Pemeriksa\Fe\DashboardPemeriksa;
use App\Http\Controllers\AdminTL\FE\DashboardAminTLController;
use App\Http\Controllers\AdminTL\FE\VerifikasiController;
use App\Http\Controllers\Login\Fe\UserController as FeUserController;

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

Route::get('/', function () {
    return view('login');
})->name('login');
// Route::get('/', [UserController::class, 'index']);
Route::post('login', [FeUserController::class, 'login'])->name('login.post');
Route::get('/logout', [FeUserController::class, 'logout']);
Route::get('/adminTL', [DashboardAminTLController::class, 'index']);
Route::get('/adminTL/pkpt', [DashboardAminTLController::class, 'pkpt']);
Route::get('/adminTL/rekom', [DashboardAminTLController::class, 'rekom']);
Route::get('/adminTL/temuanrekom', [DashboardAminTLController::class, 'temurekom']);
Route::post('/adminTL/arsip/cari', [DashboardAminTLController::class, 'arsipCari']);
Route::get('adminTL/pkpt_tambah/{id}', [DashboardAminTLController::class, 'pkptcreate']);
Route::post('adminTL/pkpt_baru/{id}', [DashboardAminTLController::class, 'pkptstore']);
Route::get('adminTL/pkpt_edit/{id}/edit', [DashboardAminTLController::class, 'pkptedit']);
Route::put('adminTL/pkpt/{id}', [DashboardAminTLController::class, 'pkptupdate']);
Route::get('adminTL/rekom_edit/{id}/edit', [DashboardAminTLController::class, 'rekomEdit']);
Route::post('adminTL/rekom', [DashboardAminTLController::class, 'rekomStore']);
Route::post('adminTL/rekom/replace-all', [DashboardAminTLController::class, 'replaceAllRekomendasi']);
Route::post('adminTL/temuan', [DashboardAminTLController::class, 'temuanStore']);
Route::get('adminTL/temuan_rekom_edit/{id}/edit', [DashboardAminTLController::class, 'temuanrekomEdit']);
// Routes for rekomendasi CRUD
Route::post('adminTL/rekomendasi/update', [DashboardAminTLController::class, 'updateRekomendasi']);
Route::post('adminTL/rekomendasi/add-sub', [DashboardAminTLController::class, 'addSubRekomendasi']);
Route::delete('adminTL/rekomendasi/{id}', [DashboardAminTLController::class, 'deleteRekomendasi']);
// Route for deleting main item and all its children
Route::post('adminTL/rekom/delete-main-item', [DashboardAminTLController::class, 'deleteMainItem']);
// Routes for temuan CRUD - Delete entire temuan with all recommendations
Route::delete('adminTL/temuan/{kode_temuan}/delete-all', [DashboardAminTLController::class, 'deleteTemuanWithAllRekomendasi']);
Route::post('adminTL/rekom/datadukung', [DashboardAminTLController::class, 'datadukungrekomStore']);
// File upload routes
Route::post('adminTL/rekom/upload-file', [DashboardAminTLController::class, 'uploadFile']);
Route::post('adminTL/rekom/delete-file', [DashboardAminTLController::class, 'deleteFile']);
// File upload routes per rekomendasi
Route::post('adminTL/rekom/upload-file-rekomendasi', [DashboardAminTLController::class, 'uploadFileRekomendasi']);
Route::post('adminTL/rekom/delete-file-rekomendasi', [DashboardAminTLController::class, 'deleteFileRekomendasi']);
// Route::get('adminTL/rekom/datadukung/{id}/edit', [DashboardAminTLController::class, 'datadukungrekomEdit']);
Route::get('adminTL/temuan_rekom/{id}', [DashboardAminTLController::class, 'temuanrekomEdit']);
Route::get('/adminTL/datadukung/rekom', [DashboardAminTLController::class, 'indexdatadukungrekom']);
Route::get('adminTL/datadukung/rekom/{id}', [DashboardAminTLController::class, 'datadukungrekomEdit']);

Route::get('adminTL/datadukung/temuan', [DashboardAminTLController::class, 'indexdatadukungtemuan']);
Route::get('adminTL/datadukung/temuan/{id}', [DashboardAminTLController::class, 'datadukungtemuanEdit']);

// User Control Routes - List User menu
Route::get('/adminTL/user-control/list-user', [UserControlController::class, 'listUser'])->name('admin.user-control.list-user');
Route::get('/adminTL/user-control/create-user', [UserControlController::class, 'createUser'])->name('admin.user-control.create-user');
Route::post('/adminTL/user-control/store-user', [UserControlController::class, 'storeUser'])->name('admin.user-control.store-user');
Route::get('/adminTL/user-control/edit-user/{id}', [UserControlController::class, 'editUser'])->name('admin.user-control.edit-user');
Route::put('/adminTL/user-control/update-user/{id}', [UserControlController::class, 'updateUser'])->name('admin.user-control.update-user');
Route::delete('/adminTL/user-control/delete-user/{id}', [UserControlController::class, 'deleteUser'])->name('admin.user-control.delete-user');

// User Control Routes - User Data menu
Route::get('/adminTL/user-control/user-data', [UserControlController::class, 'userData'])->name('admin.user-control.user-data');
Route::post('/adminTL/user-control/update-user-data-access', [UserControlController::class, 'updateUserDataAccess'])->name('admin.user-control.update-user-data-access');
Route::post('/adminTL/user-control/toggle-user-access/{userId}', [UserControlController::class, 'toggleUserAccess'])->name('admin.user-control.toggle-user-access');

// Verifikasi Data Routes
Route::get('/adminTL/verifikasi/rekomendasi', [VerifikasiController::class, 'indexRekomendasi'])->name('adminTL.verifikasi.rekomendasi');
Route::get('/adminTL/verifikasi/temuan', [VerifikasiController::class, 'indexTemuan'])->name('adminTL.verifikasi.temuan');
Route::get('/adminTL/verifikasi/{type}/{id}', [VerifikasiController::class, 'show'])->name('adminTL.verifikasi.show');
Route::post('/adminTL/verifikasi/{type}/{id}/update-status', [VerifikasiController::class, 'updateStatus'])->name('adminTL.verifikasi.updateStatus');
Route::get('/adminTL/verifikasi/{type}/{id}/status-options', [VerifikasiController::class, 'getStatusOptions'])->name('adminTL.verifikasi.statusOptions');
// Legacy routes (redirect to new structure)
Route::get('/adminTL/verifikasi', [VerifikasiController::class, 'index'])->name('adminTL.verifikasi.index');
// Route::get('/PemeriksaTL', [DashboardPemeriksaTLController::class, 'index']);
// Route::get('/Obrik', [DashboardObrikTLController::class, 'index']);

Route::get('Pemeriksa', [DashboardPemeriksa::class, 'index']);
Route::get('Pemeriksa/pkpt', [DashboardPemeriksa::class, 'pkpt']);
Route::get('Pemeriksa/rekom', [DashboardPemeriksa::class, 'rekom']);
Route::get('Pemeriksa/temuanrekom', [DashboardPemeriksa::class, 'temurekom']);
Route::post('Pemeriksa/arsip/cari', [DashboardPemeriksa::class, 'arsipCari']);
Route::get('Pemeriksa/pkpt_tambah/{id}', [DashboardPemeriksa::class, 'pkptcreate']);
Route::post('Pemeriksa/pkpt_baru/{id}', [DashboardPemeriksa::class, 'pkptstore']);
Route::get('Pemeriksa/pkpt_edit/{id}/edit', [DashboardPemeriksa::class, 'pkptedit']);
Route::put('Pemeriksa/pkpt/{id}', [DashboardPemeriksa::class, 'pkptupdate']);
Route::get('Pemeriksa/rekom_edit/{id}/edit', [DashboardPemeriksa::class, 'rekomEdit']);
Route::post('Pemeriksa/rekom', [DashboardPemeriksa::class, 'rekomStore']);
Route::post('Pemeriksa/temuan', [DashboardPemeriksa::class, 'temuanStore']);
Route::get('Pemeriksa/temuan_rekom_edit/{id}/edit', [DashboardPemeriksa::class, 'temuanrekomEdit']);
// Routes for rekomendasi CRUD
Route::post('Pemeriksa/rekomendasi/update', [DashboardPemeriksa::class, 'updateRekomendasi']);
Route::delete('Pemeriksa/rekomendasi/{id}', [DashboardPemeriksa::class, 'deleteRekomendasi']);
// Routes for temuan CRUD - Delete entire temuan with all recommendations
Route::delete('Pemeriksa/temuan/{kode_temuan}/delete-all', [DashboardPemeriksa::class, 'deleteTemuanWithAllRekomendasi']);
Route::post('Pemeriksa/rekom/datadukung', [DashboardPemeriksa::class, 'datadukungrekomStore']);
// File upload routes
Route::post('Pemeriksa/rekom/upload-file', [DashboardPemeriksa::class, 'uploadFile']);
Route::post('Pemeriksa/rekom/delete-file', [DashboardPemeriksa::class, 'deleteFile']);
// Route::get('Pemeriksa/rekom/datadukung/{id}/edit', [DashboardPemeriksa::class, 'datadukungrekomEdit']);
Route::get('Pemeriksa/temuan_rekom/{id}', [DashboardPemeriksa::class, 'temuanrekomEdit']);
Route::get('/Pemeriksa/datadukung/rekom', [DashboardPemeriksa::class, 'indexdatadukungrekom']);
Route::get('Pemeriksa/datadukung/rekom/{id}', [DashboardPemeriksa::class, 'datadukungrekomEdit']);

Route::get('OPD', [DashboardOPD::class, 'index']);
Route::get('OPD/pkpt', [DashboardOPD::class, 'pkpt']);
Route::get('OPD/rekom', [DashboardOPD::class, 'rekom']);
Route::get('OPD/temuanrekom', [DashboardOPD::class, 'temurekom']);
Route::post('OPD/arsip/cari', [DashboardOPD::class, 'arsipCari']);
Route::get('OPD/pkpt_tambah/{id}', [DashboardOPD::class, 'pkptcreate']);
Route::post('OPD/pkpt_baru/{id}', [DashboardOPD::class, 'pkptstore']);
Route::get('OPD/pkpt_edit/{id}/edit', [DashboardOPD::class, 'pkptedit']);
Route::put('OPD/pkpt/{id}', [DashboardOPD::class, 'pkptupdate']);
Route::get('OPD/rekom_edit/{id}/edit', [DashboardOPD::class, 'rekomEdit']);
Route::post('OPD/rekom', [DashboardOPD::class, 'rekomStore']);
Route::post('OPD/temuan', [DashboardOPD::class, 'temuanStore']);
Route::get('OPD/temuan_rekom_edit/{id}/edit', [DashboardOPD::class, 'temuanrekomEdit']);
// Routes for rekomendasi CRUD
Route::post('OPD/rekomendasi/update', [DashboardOPD::class, 'updateRekomendasi']);
Route::delete('OPD/rekomendasi/{id}', [DashboardOPD::class, 'deleteRekomendasi']);
// Routes for temuan CRUD - Delete entire temuan with all recommendations
Route::delete('OPD/temuan/{kode_temuan}/delete-all', [DashboardOPD::class, 'deleteTemuanWithAllRekomendasi']);
Route::post('OPD/rekom/datadukung', [DashboardOPD::class, 'datadukungrekomStore']);
// File upload routes
Route::post('OPD/rekom/upload-file', [DashboardOPD::class, 'uploadFile']);
Route::post('OPD/rekom/delete-file', [DashboardOPD::class, 'deleteFile']);
// Route::get('OPD/rekom/datadukung/{id}/edit', [DashboardOPD::class, 'datadukungrekomEdit']);
Route::get('OPD/temuan_rekom/{id}', [DashboardOPD::class, 'temuanrekomEdit']);
Route::get('/OPD/datadukung/rekom', [DashboardOPD::class, 'indexdatadukungrekom']);
Route::get('OPD/datadukung/rekom/{id}', [DashboardOPD::class, 'datadukungrekomEdit']);

// OpdTL Routes - Special Limited Access
Route::group(['prefix' => 'opdTL', 'middleware' => ['auth']], function () {
    Route::get('/', [App\Http\Controllers\OpdTL\OpdTLController::class, 'index'])->name('opdTL.dashboard');

    // Menu A1 - Data Dukung Rekomendasi (Read Only)
    Route::get('/menu-a1', [App\Http\Controllers\OpdTL\OpdTLController::class, 'menuA1'])->name('opdTL.menuA1');
    Route::get('/menu-a1/{id}', [App\Http\Controllers\OpdTL\OpdTLController::class, 'menuA1Detail'])->name('opdTL.menuA1.detail');

    // Menu A2 - Data Dukung Rekomendasi List
    Route::get('/menu-a2', [App\Http\Controllers\OpdTL\OpdTLController::class, 'menuA2'])->name('opdTL.menuA2');
    Route::get('/menu-a2/{id}', [App\Http\Controllers\OpdTL\OpdTLController::class, 'menuA2Detail'])->name('opdTL.menuA2.detail');

    // File upload (only allowed action)
    Route::post('/upload-file', [App\Http\Controllers\OpdTL\OpdTLController::class, 'uploadFile'])->name('opdTL.uploadFile');
});
