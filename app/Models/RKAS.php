<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Blameable;

class RKAS extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Blameable;

    protected $table = 't_rkas';
    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
        'deleted_by',
        'pemasukan_bos_detail_id',
        'golongan_rkas_name',
        'golongan_rkas_id',
        'sub_golongan_rkas_name',
        'sub_golongan_rkas_id',
        'description',
        'volume',
        'unit',
        'unit_price',
        'amount_total'
    ];

    public function rkas_detail() {
        return $this->hasMany(RKASDetail::class, 'rkas_id');
    }

}
