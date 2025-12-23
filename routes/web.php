<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    RegisterController,
    ProfileController,
    RawatJalanController,
    RawatInapController,
    DashboardController,
    TriaseController,
    TriasePrimerController,
    TriaseSekunderController,
    SoapController,
    DownloadController,
    HapusController
};

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.attempt');

Route::get('/login', [AuthController::class, 'show'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::middleware(['role:admin,casemix'])->group(function () {
        
        Route::get('/triase', [TriaseController::class, 'index'])
            ->name('triase.index');

        Route::put('/triase/{no_rawat}', [TriaseController::class, 'update'])
            ->where('no_rawat', '.*')
            ->name('triase.update');

        Route::get('/triase-primer', [TriasePrimerController::class, 'index'])
            ->name('triase-primer.index');

        Route::put('/triase-primer/{no_rawat}', [TriasePrimerController::class, 'update'])
            ->where('no_rawat', '.*')
            ->name('triase-primer.update');

        Route::get('/triase-sekunder', [TriaseSekunderController::class, 'index'])
            ->name('triase-sekunder.index');

        Route::put('/triase-sekunder/{no_rawat}', [TriaseSekunderController::class, 'update'])
            ->where('no_rawat', '.*')
            ->name('triase-sekunder.update');

        Route::get('/soap', [SoapController::class, 'index'])
            ->name('soap.index');

        Route::put('/soap/{no_rawat}', [SoapController::class, 'update'])
            ->where('no_rawat', '.*')
            ->name('soap.update');

        Route::get('/download', [DownloadController::class, 'index'])
            ->name('download.index');
        Route::get('/download/export', [DownloadController::class, 'export'])
            ->name('download.export');
        Route::get('/download/export/excel', [DownloadController::class, 'exportExcel'])
            ->name('download.export.excel');
        Route::get('/download/export/pdf', [DownloadController::class, 'exportPdf'])
            ->name('download.export.pdf');
        Route::get('/download/print', [DownloadController::class, 'printView'])
            ->name('download.print');

        Route::get('/hapus', [HapusController::class, 'index'])
            ->name('hapus.index');
        Route::post('/hapus/confirm', [HapusController::class, 'confirmByForm'])
            ->name('hapus.confirm.form');
        Route::delete('/hapus', [HapusController::class, 'destroy'])
            ->name('hapus');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware(['verified'])
        ->name('dashboard');

    Route::get('/rawatjalan', [RawatJalanController::class, 'index'])
        ->name('rawatjalan.index');
    Route::get('/rawatjalan/detail/{no_rawat}', [RawatJalanController::class, 'detail'])
        ->where('no_rawat', '.*')
        ->name('rawatjalan.detail');
    Route::post('/rawatjalan/{no_rawat}/upload-resume', [RawatJalanController::class, 'uploadResume'])
        ->where('no_rawat', '.*')
        ->name('rawatjalan.upload_resume');
    Route::put('/rawatjalan/{no_rawat}/update-status', [RawatJalanController::class, 'updateStatus'])
        ->where('no_rawat', '.*')
        ->name('rawatjalan.update_status');
    Route::get('/rawatjalan/statusklaim/{no_rawat}', [RawatJalanController::class, 'lihatResume'])
        ->where('no_rawat', '.*')
        ->name('rawatjalan.statusklaim');
    Route::get('/rawatjalan/{no_rawat}/pemeriksaan', [RawatJalanController::class, 'lihatPemeriksaan'])
        ->where('no_rawat', '.*')
        ->name('rawatjalan.pemeriksaan');
    Route::get('/bpjs/rawatjalan', [RawatJalanController::class, 'indexBpjs'])
        ->name('rawatjalan.index_bpjs');

    Route::get('/rawatinap', [RawatInapController::class, 'index'])
        ->name('rawatinap.index');
    Route::get('/rawatinap/detail/{no_rawat}', [RawatInapController::class, 'detail'])
        ->where('no_rawat', '.*')
        ->name('rawatinap.detail');
    Route::post('/rawatinap/{no_rawat}/upload-resume', [RawatInapController::class, 'uploadResume'])
        ->where('no_rawat', '.*')
        ->name('rawatinap.upload_resume');
    Route::put('/rawatinap/{no_rawat}/update-status', [RawatInapController::class, 'updateStatus'])
        ->where('no_rawat', '.*')
        ->name('rawatinap.update_status');
    Route::get('/rawatinap/statusklaim/{no_rawat}', [RawatInapController::class, 'lihatResume'])
        ->where('no_rawat', '.*')
        ->name('rawatinap.statusklaim');
    Route::get('/rawatranap/{no_rawat}/pemeriksaan', [RawatInapController::class, 'lihatPemeriksaan'])
        ->where('no_rawat', '.*')
        ->name('rawatinap.pemeriksaan');
    Route::get('/bpjs/rawatinap', [RawatInapController::class, 'indexBpjs'])
        ->name('rawatinap.index_bpjs');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});