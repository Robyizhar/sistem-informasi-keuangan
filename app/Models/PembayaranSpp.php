<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Blameable;

class PembayaranSpp extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Blameable;

    protected $fillable = ['siswa_id', 'total_payment', 'kelas_id', 'semester', 'bulan', 'created_by', 'updated_by', 'deleted_by'];
    protected $table = 't_pembayaran_spp';

    protected static function boot() {

        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('id', 'asc');
        });

    }

    public function siswa() {
        return $this->belongsTo(Siswa::class);
	}

}
