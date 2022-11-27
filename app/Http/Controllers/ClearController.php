<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Artisan;

class ClearController extends Controller {

    public function clearOptimize() {
        Artisan::call('optimize:clear');
        Alert::toast('Berhasil Dioptimasi', 'success');
        return redirect()->route('dashboard');
    }

    public function clearConfig() {
        Artisan::call('config:clear');
        Alert::toast('Berhasil Dioptimasi', 'success');
        return redirect()->route('dashboard');
    }

    public function clearCache() {
        Artisan::call('cache:clear');
        Alert::toast('Berhasil Dioptimasi', 'success');
        return redirect()->route('dashboard');
    }

    public function storageLinked() {
        Artisan::call('storage:link');
        Alert::toast('Berhasil Dioptimasi', 'success');
        return redirect()->route('dashboard');
    }

    public function migrate() {
        Artisan::call('migrate');
        Alert::toast('Berhasil Dioptimasi', 'success');
        return redirect()->route('dashboard');
    }

    public function migrateFresh() {
        Artisan::call('migrate:fresh');
        Alert::toast('Berhasil Dioptimasi', 'success');
        return redirect()->route('dashboard');
    }

    public function seeder() {
        Artisan::call('db:seed');
        Alert::toast('Berhasil Dioptimasi', 'success');
        return redirect()->route('dashboard');
    }

    public function ketGenerate() {
        Artisan::call('key:generate');
        Alert::toast('Berhasil Dioptimasi', 'success');
        return redirect()->route('dashboard');
    }

}
