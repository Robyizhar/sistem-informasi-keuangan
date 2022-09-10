<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelas extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['code', 'name'];
    protected $table = 'm_kelas';
    public function spp_payment() {
        return $this->hasMany(PembayaranSpp::class, 'kelas_id', 'id');
	}
}
