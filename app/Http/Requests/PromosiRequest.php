<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromosiRequest extends FormRequest
{
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'jabatan_id'            => 'required',
            'level_id'              => 'required',
            'new_jabatan_id'        => 'required',
            'new_level_id'          => 'required',
            'new_pangkat_id'        => 'required',
            'pangkat_id'            => 'required',
            'penilaian_karyawan_id' => 'required',
            'unit_kerja_id'         => 'required'
        ];
    }

    // public function messages() {
    //     return [
    //         'title.required'    => 'Judul wajib diisi !',
    //         'text.required'     => 'Link wajib diisi !',
    //         'text.url'          => 'Masukan format URL dengan benar !'
    //     ];
    // }

}
