<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClearController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Master\KelasController;
use App\Http\Controllers\Master\JurusanController;
use App\Http\Controllers\Master\AngkatanController;
use App\Http\Controllers\Master\SiswaController;
use App\Http\Controllers\Master\PemasukanBosController;
use App\Http\Controllers\Master\GolonganRKASController;
use App\Http\Controllers\Transaksi\DSPController;
use App\Http\Controllers\Transaksi\SPPController;
use App\Http\Controllers\Transaksi\PengeluaranSppDsp;
use App\Http\Controllers\Transaksi\RKASController;
use App\Http\Controllers\Siswa\PembayaranController;

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

    Route::get('/dashboard', [DashboardController::class, 'dashboardSiswa'])->name('siswa');

    Route::prefix('data-pembayaran')->group(function () {
        Route::get('/spp', [PembayaranController::class, 'getSPP'])
            ->middleware(['role:Siswa']);

        Route::get('/dsp', [PembayaranController::class, 'getDSP'])
            ->middleware(['role:Siswa']);
    });

    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index')
            ->middleware(['role_or_permission:Developer|View-User']);

        Route::post('/get-data', [UserController::class, 'getData'])
            ->middleware(['role_or_permission:Developer|View-User']);

        Route::get('/create', [UserController::class, 'create'])->name('user.create')
            ->middleware(['role_or_permission:Developer|Add-User']);

        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit')
            ->middleware(['role_or_permission:Developer|Edit-User']);

        Route::post('/store', [UserController::class, 'store'])->name('user.store')
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
    });

    Route::prefix('kelas')->group(function () {
        Route::get('/', [KelasController::class, 'index'])->name('kelas.index');

        Route::post('/get-data', [KelasController::class, 'getData']);

        Route::get('/create', [KelasController::class, 'create'])->name('kelas.create');

        Route::get('/edit/{id}', [KelasController::class, 'edit'])->name('kelas.edit');

        Route::post('/store', [KelasController::class, 'store'])->name('kelas.store');

        Route::put('/update', [KelasController::class, 'update'])->name('kelas.update');

        Route::get('/destroy/{id}', [KelasController::class, 'destroy'])->name('kelas.destroy');
    });

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

        // Route::get('/detail/{id}', [DSPController::class, 'show'])->name('dsp.detail');

        Route::post('/store', [DSPController::class, 'store'])->name('dsp.store');

        Route::get('/destroy/{id}', [DSPController::class, 'destroy'])->name('dsp.destroy');
    });

    Route::prefix('golongan-rkas')->group(function () {
        Route::get('/', [GolonganRKASController::class, 'index'])->name('golongan-rkas.index');

        Route::post('/get-data', [GolonganRKASController::class, 'getData']);

        Route::get('/create', [GolonganRKASController::class, 'create'])->name('golongan-rkas.create');

        Route::get('/edit/{id}', [GolonganRKASController::class, 'edit'])->name('golongan-rkas.edit');

        Route::post('/store', [GolonganRKASController::class, 'store'])->name('golongan-rkas.store');

        Route::put('/update', [GolonganRKASController::class, 'update'])->name('golongan-rkas.update');

        Route::get('/destroy/{id}', [GolonganRKASController::class, 'destroy'])->name('golongan-rkas.destroy');
    });

    Route::prefix('spp')->group(function () {
        Route::get('/', [SPPController::class, 'index'])->name('spp.index');

        Route::post('/get-data', [SPPController::class, 'getData']);

        Route::post('/get-siswa', [SPPController::class, 'getSiswa']);

        Route::post('/get-payment', [SPPController::class, 'getPayment']);

        Route::get('/create', [SPPController::class, 'create'])->name('spp.create');

        Route::get('/detail/{id}', [SPPController::class, 'show'])->name('spp.detail');

        Route::post('/store', [SPPController::class, 'store'])->name('spp.store');

        Route::get('/destroy/{id}', [SPPController::class, 'destroy'])->name('spp.destroy');

        Route::post('/filter', [SPPController::class, 'filter'])->name('spp.filter');
    });

    Route::prefix('pengeluaran-spp-dsp')->group(function () {
        Route::get('/', [PengeluaranSppDsp::class, 'index'])->name('pengeluaran-spp-dsp.index');

        Route::post('/get-data', [PengeluaranSppDsp::class, 'getData']);

        Route::get('/create', [PengeluaranSppDsp::class, 'create'])->name('pengeluaran-spp-dsp.create');

        // Route::get('/detail/{id}', [PengeluaranSppDsp::class, 'show'])->name('pengeluaran-spp-dsp.detail');

        Route::post('/store', [PengeluaranSppDsp::class, 'store'])->name('pengeluaran-spp-dsp.store');

        // Route::get('/destroy/{id}', [PengeluaranSppDsp::class, 'destroy'])->name('pengeluaran-spp-dsp.destroy');
    });

    Route::prefix('pemasukan-bos')->group(function () {
        Route::get('/', [PemasukanBosController::class, 'index'])->name('pemasukan-bos.index');

        Route::post('/get-data', [PemasukanBosController::class, 'getData']);

        Route::post('/get-detail', [PemasukanBosController::class, 'getDetail']);

        Route::get('/create', [PemasukanBosController::class, 'create'])->name('pemasukan-bos.create');

        Route::get('/edit/{id}', [PemasukanBosController::class, 'edit'])->name('pemasukan-bos.edit');

        Route::post('/store', [PemasukanBosController::class, 'store'])->name('pemasukan-bos.store');

        Route::put('/update', [PemasukanBosController::class, 'update'])->name('pemasukan-bos.update');

        Route::get('/destroy/{id}', [PemasukanBosController::class, 'destroy'])->name('pemasukan-bos.destroy');
    });

    Route::prefix('rkas')->group(function () {
        Route::get('/', [RKASController::class, 'index'])->name('rkas.index');

        Route::post('/get-data', [RKASController::class, 'getData']);

        Route::get('/create', [RKASController::class, 'create'])->name('rkas.create');

        Route::get('/detail/{id}', [RKASController::class, 'show'])->name('rkas.detail');

        Route::post('/store', [RKASController::class, 'store'])->name('rkas.store');

        // Route::get('/destroy/{id}', [RKASController::class, 'destroy'])->name('rkas.destroy');
    });

});
