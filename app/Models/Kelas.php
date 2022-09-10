<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Blameable;

class Kelas extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Blameable;

    protected $fillable = ['code', 'name', 'created_by', 'updated_by', 'deleted_by'];
    protected $table = 'm_kelas';

    public function spp_payment() {
        return $this->hasMany(PembayaranSpp::class, 'kelas_id', 'id');
	}
}
