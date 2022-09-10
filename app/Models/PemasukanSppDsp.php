<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemasukanSppDsp extends Model
{
    use HasFactory;
    protected $table = 't_pemasukan_spp_dsp';
    protected $fillable = ['income_source', 'income_total', 'pembayaran_dsp_id,', 'siswa_id'];
}
