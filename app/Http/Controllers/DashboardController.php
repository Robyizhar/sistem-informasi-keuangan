<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\BaseRepository;
use Auth;

class DashboardController extends Controller {

    // protected $Karyawan;

    public function __construct() {
        // $this->Karyawan = new BaseRepository($Karyawan);
    }

    public function index() {
        if (Auth::user()->getRoleNames()[0] == 'Siswa')
            return redirect('dashboard');

        $data = [
            'organik' => ''
        ];

        // return $data;

        return view('dashboard.dashboard', compact('data'));
    }

    public function dashboardSiswa() {
        if (Auth::user()->getRoleNames()[0] != 'Siswa')
            return redirect('/');

        return view('dashboard.dashboard-siswa');
    }

    public function getData() {

    }

    public function create() {

    }

    public function store(Request $request) {

    }

    public function show($id) {

    }

    public function edit($id) {

    }

    public function update(Request $request, $id) {

    }

    public function destroy($id) {

    }
}
