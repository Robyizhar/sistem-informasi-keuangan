<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PemasukanSppDsp extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 't_pemasukan_spp_dsp';
    protected $fillable = ['income_source', 'income_total', 'pembayaran_dsp_id,', 'siswa_id'];
}
