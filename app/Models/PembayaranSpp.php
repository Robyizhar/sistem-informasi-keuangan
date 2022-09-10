<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class PembayaranSpp extends Model
{
    use HasFactory;
    protected $fillable = ['siswa_id', 'total_payment', 'kelas_id', 'semester', 'bulan'];
    protected $table = 't_pembayaran_spp';
    public function siswa() {
        return $this->belongsTo(Siswa::class);
	}

    protected static function boot() {

        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('id', 'asc');
        });

    }
}
