<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    protected $fillable = ['address', 'name', 'gender', 'angkatan_id', 'jurusan_id'];

    public function jurusan() {
        return $this->belongsTo(Jurusan::class);
	}

    public function angkatan() {
        return $this->belongsTo(Angkatan::class);
    }
}
