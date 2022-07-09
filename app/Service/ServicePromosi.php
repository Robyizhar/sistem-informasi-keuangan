<?php

namespace App\Service;

use App\Http\Controllers\Controller;
use DB;

class ServicePromosi extends Controller {

    public function getData($id = null) {

        $query = DB::table('promosi_karyawan')
            ->select('promosi_karyawan.*',
                'penilaian_karyawan.no AS no_sertifikasi',
                'penilaian_karyawan.file_sertifikasi AS file_sertifikasi',
                'penilaian_karyawan.nilai_kedisiplinan AS nilai_kedisiplinan',
                'penilaian_karyawan.keterangan_hukuman AS keterangan_hukuman',
                'penilaian_karyawan.keyword AS keyword',
                'penilaian_karyawan.nilai_kepatuhan AS nilai_kepatuhan',
                'penilaian_karyawan.nilai_sikap_kerja AS nilai_sikap_kerja',
                'penilaian_karyawan.nilai_inisiatif AS nilai_inisiatif',
                'penilaian_karyawan.status_promosi AS status_promosi',
                'penilaian_karyawan.persentase AS persentase',
                'penilaian_karyawan.created_at AS waktu_penilaian',
                'penilaian_karyawan.id AS penilaian_karyawan_id',
                'karyawans.np AS np',
                'karyawans.nama_lengkap AS nama_lengkap',
                'karyawans.id AS id_karyawan',
                'karyawans.tmt_jabatan AS tmt_jabatan',

                'levels.nama AS nama_level',
                'jabatans.nama AS nama_jabatan',
                'pangkats.nama AS nama_pangkat',
                'units.nama AS nama_unit',

                'jabatans.id AS id_jabatan',
                'units.id AS id_unit',
                'levels.id AS id_level',
                'pangkats.id AS id_pangkat'

            )
            ->rightjoin('penilaian_karyawan', 'promosi_karyawan.penilaian_karyawan_id', '=', 'penilaian_karyawan.id')
            ->join('karyawans', 'penilaian_karyawan.id_karyawan', '=', 'karyawans.id')
            ->join('levels', 'karyawans.level_id', '=', 'levels.id')
            ->join('jabatans', 'karyawans.jabatan_id', '=', 'jabatans.id')
            ->join('pangkats', 'karyawans.pangkat_id', '=', 'pangkats.id')
            ->join('units', 'karyawans.unit_kerja_id', '=', 'units.id')
            ;
        if($id != null)
            $query->where('promosi_karyawan.id', $id);

        return $query;
    }

}
