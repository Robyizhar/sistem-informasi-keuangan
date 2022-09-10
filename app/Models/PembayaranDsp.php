<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Blameable;

class PembayaranDsp extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Blameable;

    protected $fillable = ['siswa_id', 'total_payment', 'created_by', 'updated_by', 'deleted_by'];
    protected $table = 't_pembayaran_dsp';

    public function siswa() {
        return $this->belongsTo(Siswa::class);
	}
}
