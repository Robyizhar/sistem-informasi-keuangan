<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClearController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Master\JurusanController;
use App\Http\Controllers\Master\AngkatanController;
use App\Http\Controllers\Master\SiswaController;
use App\Http\Controllers\Transaksi\DSPController;

Auth::routes();

Route::prefix('clear')->group(function () {

    Route::get('/all', [ClearController::class, 'clearOptimize'])->name('clear.all');
    Route::get('/config', [ClearController::class, 'clearConfig'])->name('clear.config');
    Route::get('/cache', [ClearController::class, 'clearCache'])->name('clear.cache');
    Route::get('/storage-link', [ClearController::class, 'storageLinked'])->name('storage.link');
    Route::get('/migrate', [ClearController::class, 'migrate'])->name('migrate');
    Route::get('/seed', [ClearController::class, 'seeder'])->name('seed');
    Route::get('/generate', [ClearController::class, 'ketGenerate'])->name('generate');
});

Route::get('/register', function() {
    return redirect('/login');
});

Route::post('/register', function() {
    return redirect('/login');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index')
            ->middleware(['role_or_permission:Developer|View-User']);

        Route::post('/get-data', [UserController::class, 'getData'])
            ->middleware(['role_or_permission:Developer|View-User']);

        Route::get('/create', [UserController::class, 'create'])->name('user.create')
            ->middleware(['role_or_permission:Developer|Add-User']);

        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit')
            ->middleware(['role_or_permission:Developer|Edit-User']);

        Route::post('/store', [UserController::class, 'Add'])->name('user.store')
            ->middleware(['role_or_permission:Developer|Edit-User']);

        Route::put('/update', [UserController::class, 'update'])->name('user.update')
            ->middleware(['role_or_permission:Developer|Edit-User']);

        Route::get('/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy')
            ->middleware(['role_or_permission:Developer|Delete-User']);
    });

    Route::prefix('role')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('role.index')
            ->middleware(['role_or_permission:Developer|View-User Group']);

        Route::post('/get-data', [RoleController::class, 'getData'])
            ->middleware(['role_or_permission:Developer|View-User Group']);

        Route::get('/create', [RoleController::class, 'create'])->name('role.create')
            ->middleware(['role_or_permission:Developer|Add-User Group']);

        Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('role.edit')
            ->middleware(['role_or_permission:Developer|Edit-User Group']);

        Route::post('/store', [RoleController::class, 'store'])->name('role.store')
            ->middleware(['role_or_permission:Developer|Edit-User Group']);

        Route::put('/update', [RoleController::class, 'update'])->name('role.update')
            ->middleware(['role_or_permission:Developer|Edit-User Group']);

        Route::get('/destroy/{id}', [RoleController::class, 'destroy'])->name('role.destroy')
            ->middleware(['role_or_permission:Developer|Delete-User Group']);
    });;

    Route::prefix('jurusan')->group(function () {
        Route::get('/', [JurusanController::class, 'index'])->name('jurusan.index');

        Route::post('/get-data', [JurusanController::class, 'getData']);

        Route::get('/create', [JurusanController::class, 'create'])->name('jurusan.create');

        Route::get('/edit/{id}', [JurusanController::class, 'edit'])->name('jurusan.edit');

        Route::post('/store', [JurusanController::class, 'store'])->name('jurusan.store');

        Route::put('/update', [JurusanController::class, 'update'])->name('jurusan.update');

        Route::get('/destroy/{id}', [JurusanController::class, 'destroy'])->name('jurusan.destroy');
    });

    Route::prefix('angkatan')->group(function () {
        Route::get('/', [AngkatanController::class, 'index'])->name('angkatan.index');

        Route::post('/get-data', [AngkatanController::class, 'getData']);

        Route::get('/create', [AngkatanController::class, 'create'])->name('angkatan.create');

        Route::get('/edit/{id}', [AngkatanController::class, 'edit'])->name('angkatan.edit');

        Route::post('/store', [AngkatanController::class, 'store'])->name('angkatan.store');

        Route::put('/update', [AngkatanController::class, 'update'])->name('angkatan.update');

        Route::get('/destroy/{id}', [AngkatanController::class, 'destroy'])->name('angkatan.destroy');
    });

    Route::prefix('siswa')->group(function () {
        Route::get('/', [SiswaController::class, 'index'])->name('siswa.index');

        Route::post('/get-data', [SiswaController::class, 'getData']);

        Route::get('/create', [SiswaController::class, 'create'])->name('siswa.create');

        Route::get('/edit/{id}', [SiswaController::class, 'edit'])->name('siswa.edit');

        Route::post('/store', [SiswaController::class, 'store'])->name('siswa.store');

        Route::put('/update', [SiswaController::class, 'update'])->name('siswa.update');

        Route::get('/destroy/{id}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
    });

    Route::prefix('dsp')->group(function () {
        Route::get('/', [DSPController::class, 'index'])->name('dsp.index');

        Route::post('/get-data', [DSPController::class, 'getData']);

        Route::post('/get-siswa', [DSPController::class, 'getSiswa']);

        Route::get('/create', [DSPController::class, 'create'])->name('dsp.create');

        Route::get('/detail/{id}', [DSPController::class, 'show'])->name('dsp.detail');

        Route::post('/store', [DSPController::class, 'store'])->name('dsp.store');

        Route::get('/destroy/{id}', [DSPController::class, 'destroy'])->name('dsp.destroy');
    });

});
