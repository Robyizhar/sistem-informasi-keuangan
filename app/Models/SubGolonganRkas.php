<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Blameable;

class SubGolonganRkas extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Blameable;

    protected $table = 'm_sub_golongan_rkas';
    protected $fillable = ['golongan_rkas_id', 'name', 'created_by', 'updated_by', 'deleted_by', 'volume'];

    public function rkas() {
        return $this->hasMany(RKAS::class, 'sub_golongan_rkas_id');
    }
}
