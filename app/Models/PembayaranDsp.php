<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PembayaranDsp extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['siswa_id', 'total_payment'];
    protected $table = 't_pembayaran_dsp';
    public function siswa() {
        return $this->belongsTo(Siswa::class);
	}
}
