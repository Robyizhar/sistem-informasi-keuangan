<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Blameable;

class Jurusan extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Blameable;

    protected $table = 'm_jurusan';
    protected $fillable = ['code', 'name', 'created_by', 'updated_by', 'deleted_by'];
}
