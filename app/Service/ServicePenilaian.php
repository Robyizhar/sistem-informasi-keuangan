<?php

namespace App\Service;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use File;
use DB;

class ServicePenilaian extends Controller {

    public function getData($id = null) {

        $query = DB::table('penilaian_karyawan')
            ->select('penilaian_karyawan.*',
                'karyawans.nama_lengkap AS nama_lengkap',
                'karyawans.np AS np',
                'levels.nama AS nama_level',
                'jabatans.nama AS nama_jabatan',
                'pangkats.nama AS nama_pangkat'
            )
            ->leftjoin('karyawans', 'penilaian_karyawan.id_karyawan', '=', 'karyawans.id')
            ->leftjoin('levels', 'penilaian_karyawan.sertifikasi_lsp', '=', 'levels.id')
            ->leftjoin('jabatans', 'karyawans.jabatan_id', '=', 'jabatans.id')
            ->leftjoin('pangkats', 'karyawans.pangkat_id', '=', 'pangkats.id')
            ->where('penilaian_karyawan.status_promosi', false);

        if($id != null)
            $query->where('penilaian_karyawan.id', $id);

        return $query;
    }

    public function getDataNKI($id = null) {

        $query = DB::table('penilaian_nkis')
            ->select('penilaian_nkis.*',
                'karyawan_pkwt.nama AS nama_lengkap',
                'karyawan_pkwt.np AS np'
            )
            ->leftjoin('karyawan_pkwt', 'penilaian_nkis.karyawan_id', '=', 'karyawan_pkwt.id')
            ->where('penilaian_nkis.status_kontrak', false);

        if($id != null)
            $query->where('penilaian_nkis.id', $id);

        return $query;
    }

}
