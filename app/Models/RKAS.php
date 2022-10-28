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
        'deleted_by'
    ];

    public function rkas_detail() {
        return $this->hasMany(RKASDetail::class, 'golongan_rkas_id');
    }

}
