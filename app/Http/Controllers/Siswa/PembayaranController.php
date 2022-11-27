<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;
use App\Models\Siswa;

class PembayaranController extends Controller
{
    public function getSPP() {
        try {
            $siswa = Auth::user()->siswa;
            if (isset(Auth::user()->siswa)) {
                $data['siswa'] = Siswa::with('angkatan', 'jurusan', 'spp')->where('id', $siswa->id)->firstOrFail();
            }
            return view('siswa.spp', compact('data'));
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('dashboard');
        }
    }

    public function getDSP() {
        try {
            $siswa = Auth::user()->siswa;
            if (isset(Auth::user()->siswa)) {
                $data['siswa'] = Siswa::with('angkatan', 'jurusan', 'spp')->where('id', $siswa->id)->firstOrFail();
            }
            return view('siswa.dsp', compact('data'));
        } catch (\Throwable $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->route('dashboard');
        }
    }
}
