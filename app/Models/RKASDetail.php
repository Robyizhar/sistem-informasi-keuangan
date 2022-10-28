<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Blameable;

class RKASDetail extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Blameable;

    protected $table = 't_rkas';
    protected $fillable = [
        'rkas_id',
        'golongan_rkas_id',
        'sub_golongan_rkas_id',
        'pemasukan_bos_id',
        'description',
        'volume',
        'unit',
        'unit_price',
        'amount_total',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function golongan_rkas() {
        return $this->belongsTo(GolonganRkas::class, 'golongan_rkas_id');
    }

    public function sub_golongan_rkas() {
        return $this->belongsTo(GolonganRkas::class, 'sub_golongan_rkas_id');
    }

    public function pemasukan_bos() {
        return $this->belongsTo(GolonganRkas::class, 'pemasukan_bos_id');
    }
}
