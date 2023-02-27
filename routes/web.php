<?php

use App\Http\Controllers\Admin\JenisSuratController;
use App\Http\Controllers\Admin\SuratKeluarController;
use App\Http\Controllers\Admin\SuratMasukController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\ArsipSuratController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KlasifikasiController;
use App\Http\Controllers\KomponenController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\TemplateSuratController;
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


require __DIR__ . '/auth.php';

// Arsip
Route::prefix('arsip')->name('arsip.')->group(function () {
    // Dokumen
    route::get('dokumen/remove/{id}', [DocumentController::class, 'destroy'])
        ->name('dokumen.remove');

    route::resource('dokumen', DocumentController::class);

    // Upload Dokumen
    Route::post('dokumen/{id}/upload', [DocumentController::class, 'upload'])
        ->name('dokumen.upload');

    // Import Document
    Route::post('dokumen/data/import', [DocumentController::class, 'import'])
        ->name('dokumen.import');

    Route::get('dokumen/sample/download', [DocumentController::class, 'exportSample'])
        ->name('download.sample.dokumen');
    Route::get('dokumen/all/export', [DocumentController::class, 'export'])
        ->name('export.dokumen');

    // Lokasi Dokumen
    Route::post('dokumen/{id}/lokasi/store', [DocumentController::class, 'setLokasi'])
        ->name('dokumen.set.lokasi');
    Route::post('dokumen/{id}/lokasi/update', [DocumentController::class, 'updateLokasi'])
        ->name('dokumen.update.lokasi');
    Route::get('dokumen/{id}/lokasi/delete', [DocumentController::class, 'deleteLokasi'])
        ->name('dokumen.delete.lokasi');

    Route::get('dokumen/{uuid}/download', [DocumentController::class, 'download'])
        ->name('dokumen.download');



    // Surat
    route::get('/surat', [ArsipSuratController::class, 'index']);
});

// Surat Masuk
Route::resource('suratmasuk', SuratMasukController::class);
Route::get('suratmasuk/{id}/download', [SuratMasukController::class, 'downloadSuratMasuk'])
    ->name('download.suratmasuk');

Route::post('suratmasuk/{id}/upload', [SuratMasukController::class, 'uploadDocument'])
    ->name('upload.document.suratmasuk');

// Lampiran
Route::post('suratmasuk/{uuid}/store/lampiran', [SuratMasukController::class, 'uploadLampiran'])
    ->name('suratmasuk.upload.lampiran');
Route::get('lampiran/{id}/download', [SuratMasukController::class, 'downloadLampiran'])
    ->name('download.lampiran');
Route::get('lampiran/{id}/delete', [SuratMasukController::class, 'deleteLampiran'])
    ->name('delete.lampiran');

// Lokasi Surat Masuk
Route::post('suratmasuk/{id}/lokasi/store', [SuratMasukController::class, 'setLokasi'])
    ->name('suratmasuk.set.lokasi');
Route::post('suratmasuk/{id}/lokasi/update', [SuratMasukController::class, 'updateLokasi'])
    ->name('suratmasuk.update.lokasi');
Route::get('suratmasuk/{id}/lokasi/delete', [SuratMasukController::class, 'deleteLokasi'])
    ->name('suratmasuk.delete.lokasi');

// Disposisi
Route::post('suratmasuk/{id}/disposisi', [SuratMasukController::class, 'storeDisposisi'])
    ->name('suratmasuk.store.disposisi');
Route::post('suratmasuk/{id}/update/disposisi', [SuratMasukController::class, 'updateDisposisi'])
    ->name('suratmasuk.update.disposisi');

// Surat Keluar
Route::resource('suratkeluar', SuratKeluarController::class);
Route::get('suratkeluar/{id}/download', [SuratKeluarController::class, 'downloadSuratKeluar'])
    ->name('download.suratkeluar');

Route::post('suratkeluar/{id}/upload', [SuratKeluarController::class, 'uploadDocument'])
    ->name('upload.document.suratkeluar');

// Lokasi Surat Masuk
Route::post('suratkeluar/{id}/lokasi/store', [SuratKeluarController::class, 'setLokasi'])
    ->name('suratkeluar.set.lokasi');
Route::post('suratkeluar/{id}/lokasi/update', [SuratKeluarController::class, 'updateLokasi'])
    ->name('suratkeluar.update.lokasi');
Route::get('suratkeluar/{id}/lokasi/delete', [SuratKeluarController::class, 'deleteLokasi'])
    ->name('suratkeluar.delete.lokasi');

// Riwayat Surat Keluar
Route::post('suratkeluar/{id}/riwayat', [SuratKeluarController::class, 'storeRiwayat'])
    ->name('suratkeluar.store.riwayat');
Route::post('suratkeluar/{id}/update/riwayat', [SuratKeluarController::class, 'updateRiwayat'])
    ->name('suratkeluar.update.riwayat');

Route::post('suratkeluar/{id}/approve', [SuratKeluarController::class, 'approveSuratKeluar'])
    ->name('suratkeluar.approve');
Route::post('suratkeluar/{id}/send', [SuratKeluarController::class, 'sendSuratKeluar'])
    ->name('suratkeluar.send');
Route::post('suratkeluar/{id}/preview', [TemplateSuratController::class, 'download'])->name('suratkeluar.preview');
// Disposisi
Route::resource('disposisi', DisposisiController::class);

// Laporan
Route::get('laporan', function () {
    return view('pages.laporan');
});

// Data Master
Route::prefix('data-master')->middleware(['auth'])->name('data-master.')->group(function () {
    // Komponen
    Route::resource('komponen', KomponenController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::post('komponen/import', [KomponenController::class, 'import'])
        ->name('komponen.import');
    Route::get('komponen/sample/download', [KomponenController::class, 'exportSample'])
        ->name('download.sample.komponen');
    Route::get('komponen/all/export', [KomponenController::class, 'export'])
        ->name('export.komponen');


    // Klasifikasi
    Route::resource('klasifikasi', KlasifikasiController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::post('klasifikasi/import', [KlasifikasiController::class, 'import'])
        ->name('klasifikasi.import');
    Route::post('klasifikasi/data', [KlasifikasiController::class, 'data'])
        ->name('klasifikasi.data');
    Route::get('klasifikasi/sample/download', [KlasifikasiController::class, 'exportSample'])
        ->name('download.sample.klasifikasi');
    Route::get('klasifikasi/all/export', [KlasifikasiController::class, 'export'])
        ->name('export.klasifikasi');

    // Kearsipan
    Route::resource('kearsipan', LokasiController::class)->only(['index', 'store', 'update', 'destroy']);

    // JenisSurat
    Route::resource('jenissurat', JenisSuratController::class)->only(['index', 'store', 'update', 'destroy']);

    // Template Surat
    Route::resource('template', TemplateSuratController::class)->only(['index', 'store', 'update', 'destroy']);

    Route::get('template/{id}/download', [TemplateSuratController::class, 'download'])->name('template.download');

    // User-management
    Route::prefix('user-management')->name('user-management.')->group(function () {
        // Divisi
        Route::resource('divisi', DivisiController::class)->only(['index', 'store', 'update', 'destroy']);

        // Hak-akses
        Route::get('hak-akses', [RoleController::class, 'index'])
            ->name('hak-akses.index');
        Route::post('hak-akses', [RoleController::class, 'store'])
            ->name('hak-akses.store');
        Route::get('hak-akses/{id}/show', [RoleController::class, 'show'])
            ->name('hak-akses.show');
        Route::post('hak-akses/{id}/update', [RoleController::class, 'update'])
            ->name('hak-akses.update');
        Route::get('hak-akses/{id}/destroy', [RoleController::class, 'destroy'])
            ->name('hak-akses.destroy');

        // Permission
        Route::resource('permission', PermissionController::class)->only(['index', 'store', 'update']);
        Route::get('permission/{id}/destroy', [PermissionController::class, 'destroy'])
            ->name('permission.destroy');
        // Pengguna
        Route::get('user', [UserController::class, 'index'])
            ->name('pengguna.index');
        Route::get('user/create', [UserController::class, 'create'])
            ->name('pengguna.create');
        Route::post('user/store', [UserController::class, 'store'])
            ->name('pengguna.store');
        // Route::get('pengguna/{id}/edit', [UserController::class, 'edit'])
        //     ->name('pengguna.edit');
        Route::post('user/{id}', [UserController::class, 'update'])
            ->name('pengguna.update');
        Route::get('user/{id}', [UserController::class, 'destroy'])
            ->name('pengguna.destroy');
    });
});

Route::get('/', [HomeController::class, 'index']);

Route::get('/dashboard', [HomeController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');

