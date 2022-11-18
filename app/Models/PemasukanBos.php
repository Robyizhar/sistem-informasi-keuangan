<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Blameable;

class PemasukanBos extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Blameable;

    protected $table = 'm_pemasukan_bos';
    protected $fillable = ['year', 'type', 'name', 'created_by', 'updated_by', 'deleted_by'];
    protected static function boot() {
		parent::boot();

		if (Auth::check()) {

            static::deleting(function ($model) {
				$model->pemasukan_detail()->each(function($pemasukan_detail) {
					$pemasukan_detail->delete();
				});
                $model->deleted_by = auth()->id();
                $model->save();
            });

		}
	}

    public function pemasukan_detail() {
        return $this->hasMany(PemasukanBosDetail::class, 'm_pemasukan_bos_id');
    }

}
