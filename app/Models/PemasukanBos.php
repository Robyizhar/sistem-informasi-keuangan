<?php

namespace App\Models;

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
    protected $fillable = ['year', 'type', 'step', 'received_funds', 'created_by', 'updated_by', 'deleted_by'];

}
