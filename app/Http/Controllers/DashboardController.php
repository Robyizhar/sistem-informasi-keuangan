<?php

namespace App\Http\Controllers;

use App\Models\PemasukanSppDsp;
use App\Models\PembayaranDsp;
use App\Models\PengeluaranSppDsp;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;
use App\Models\Siswa;
use App\Models\PembayaranSpp;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Angkatan;
use App\Models\User;
use Auth;

class DashboardController extends Controller {

    // protected $Karyawan;

    public function __construct() {
        // $this->Karyawan = new BaseRepository($Karyawan);
    }

    public function index() {
        if (Auth::user()->getRoleNames()[0] == 'Siswa')
            return redirect('dashboard');

        $Pembayaran_spp = PembayaranSpp::get();
        $jumlah_spp = 0;
        foreach ($Pembayaran_spp as $Pembayaran) {
            $jumlah_spp += $Pembayaran->total_payment;

        }
        $Pembayaran_dsp = PembayaranDsp::get();
        $jumlah_dsp = 0;
        foreach ($Pembayaran_dsp as $Pembayaran) {
            $jumlah_dsp += $Pembayaran->total_payment;

        }

        $data = [
            'jumlah_siswa'    => Siswa::count(),
            'Pembayaran_spp'
            => $jumlah_spp,
            'Pembayaran_dsp'
            => $jumlah_dsp,
            'Pengeluaran_Spp_Dsp' => PengeluaranSppDsp::count(),
            'seluruh_jurusan'=> Jurusan::count(),
            'seluruh_kelas'=> Kelas::count(),
            'seluruh_angkatan'=>Angkatan::count()


        ];

        // return $data;

        return view('dashboard.dashboard', compact('data'));
    }
}
