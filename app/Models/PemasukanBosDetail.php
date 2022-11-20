<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Blameable;

class PemasukanBosDetail extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Blameable;

    protected $table = 'm_pemasukan_bos_detail';
    protected $fillable = ['name', 'received_funds', 'start_date', 'end_date', 'created_by', 'updated_by', 'deleted_by', 'm_pemasukan_bos_id'];

}
