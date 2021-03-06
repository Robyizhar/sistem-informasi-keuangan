<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranDsp extends Model
{
    use HasFactory;
    protected $fillable = ['siswa_id', 'total_payment', 'pembayaran_dsp_id', 'pembayaran_ssp_id'];

    public function siswa() {
        return $this->belongsTo(Siswa::class);
	}
}
