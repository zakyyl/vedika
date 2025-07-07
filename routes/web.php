<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    RegisterController,
    ProfileController,
    RawatJalanController,
    RawatInapController,
    DashboardController
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

    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['verified'])->name('dashboard');

    Route::get('/rawatjalan', [RawatJalanController::class, 'index'])->name('rawatjalan.index');
    Route::get('/rawatjalan/detail/{no_rawat}', [RawatJalanController::class, 'detail'])->where('no_rawat', '.*')->name('rawatjalan.detail');
    Route::post('/rawatjalan/{no_rawat}/upload-resume', [RawatJalanController::class, 'uploadResume'])->where('no_rawat', '.*')->name('rawatjalan.upload_resume');
    Route::put('/rawatjalan/{no_rawat}/update-status', [RawatJalanController::class, 'updateStatus'])->where('no_rawat', '.*')->name('rawatjalan.update_status');
    Route::get('/rawatjalan/statusklaim/{no_rawat}', [RawatJalanController::class, 'lihatResume'])->where('no_rawat', '.*')->name('rawatjalan.statusklaim');
    Route::get('/rawatjalan/{no_rawat}/pemeriksaan', [RawatJalanController::class, 'lihatPemeriksaan'])->where('no_rawat', '.*')->name('rawatjalan.pemeriksaan');
    Route::get('/bpjs/rawatjalan', [RawatJalanController::class, 'indexBpjs'])->name('rawatjalan.index_bpjs');

    Route::get('/rawatinap', [RawatInapController::class, 'index'])->name('rawatinap.index');
    Route::get('/rawatinap/detail/{no_rawat}', [RawatInapController::class, 'detail'])->where('no_rawat', '.*')->name('rawatinap.detail');
    Route::post('/rawatinap/{no_rawat}/upload-resume', [RawatInapController::class, 'uploadResume'])->where('no_rawat', '.*')->name('rawatinap.upload_resume');
    Route::put('/rawatinap/{no_rawat}/update-status', [RawatInapController::class, 'updateStatus'])->where('no_rawat', '.*')->name('rawatinap.update_status');
    Route::get('/rawatinap/statusklaim/{no_rawat}', [RawatInapController::class, 'lihatResume'])->where('no_rawat', '.*')->name('rawatinap.statusklaim');
    Route::get('/rawatranap/{no_rawat}/pemeriksaan', [RawatInapController::class, 'lihatPemeriksaan'])->where('no_rawat', '.*')->name('rawatinap.pemeriksaan');
    Route::get('/bpjs/rawatinap', [RawatInapController::class, 'indexBpjs'])->name('rawatinap.index_bpjs');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
