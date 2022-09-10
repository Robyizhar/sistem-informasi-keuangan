<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Blameable;

class Angkatan extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Blameable;

    protected $table = 'm_angkatan';
    protected $fillable = ['entry_year', 'name', 'dsp_cost', 'spp_cost', 'created_by', 'updated_by', 'deleted_by'];
}
