<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name'];

    public function spp_payment() {
        return $this->hasMany(PembayaranSpp::class, 'kelas_id', 'id');
	}
}
