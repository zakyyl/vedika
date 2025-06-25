    <?php

    use App\Http\Controllers\ProfileController;
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Auth;

    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\RegisterController;

    use App\Http\Controllers\RawatJalanController;
    use App\Http\Controllers\RawatInapController;
    use App\Http\Controllers\DashboardController;


    Route::get('/', function () {
        return auth()->check()
            ? redirect()->route('dashboard')
            : redirect()->route('login');
    });

    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.attempt');

    Route::get('/login',  [AuthController::class, 'show'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

    Route::get('/dashboard', function () {
        return view('dashboardmain');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::get('/rawatjalan', [RawatJalanController::class, 'index'])->name('rawatjalan.index');
    Route::get('/rawatinap', [RawatInapController::class, 'index'])->name('rawatinap.index');

    Route::get('/rawatjalan/detail/{no_rawat}', [RawatJalanController::class, 'detail'])
        ->where('no_rawat', '.*')
        ->name('rawatjalan.detail');
    Route::get('/rawatinap/detail/{no_rawat}', [RawatInapController::class, 'detail'])
        ->where('no_rawat', '.*')
        ->name('rawatinap.detail');

    Route::post('/rawatjalan/{no_rawat}/upload-resume', [RawatJalanController::class, 'uploadResume'])
        ->where('no_rawat', '.*')
        ->name('rawatjalan.upload_resume');
    Route::post('/rawatinap/{no_rawat}/upload-resume', [RawatInapController::class, 'uploadResume'])
        ->where('no_rawat', '.*')
        ->name('rawatinap.upload_resume');

    Route::put('/rawatinap/{no_rawat}/update-status', [RawatInapController::class, 'updateStatus'])->name('rawatinap.update_status');
    Route::put('/rawatjalan/{no_rawat}/update-status', [RawatInapController::class, 'updateStatus'])->name('rawatjalan.update_status');
    // Untuk rawat inap
    Route::get('/rawatinap/statusklaim/{no_rawat}', [RawatInapController::class, 'lihatResume'])
        ->where('no_rawat', '.*')
        ->name('rawatinap.statusklaim');

    // Untuk rawat jalan
    Route::get('/rawatjalan/statusklaim/{no_rawat}', [RawatJalanController::class, 'lihatResume'])
        ->where('no_rawat', '.*')
        ->name('rawatjalan.statusklaim');


    Route::get('/rawatjalan/{no_rawat}/pemeriksaan', [RawatJalanController::class, 'lihatPemeriksaan'])
        ->where('no_rawat', '.*')
        ->name('rawatjalan.pemeriksaan');

    Route::get('/rawatranap/{no_rawat}/pemeriksaan', [RawatInapController::class,  'lihatPemeriksaan'])
        ->where('no_rawat', '.*')
        ->name('rawatinap.pemeriksaan');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
