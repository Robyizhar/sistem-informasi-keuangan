<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Blameable;

class GolonganRkas extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Blameable;

    protected $table = 'm_golongan_rkas';
    protected $fillable = ['code', 'name', 'created_by', 'updated_by', 'deleted_by', 'pemasukan_bos_id'];

    protected static function boot() {
		parent::boot();

        static::deleting(function ($model) {
            $model->sub_golongan()->each(function($sub_golongan) {
                $sub_golongan->delete();
            });
            $model->deleted_by = auth()->id();
            $model->save();
        });

	}

    public function sub_golongan() {
        return $this->hasMany(SubGolonganRkas::class, 'golongan_rkas_id');
    }
}
