<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Blameable;

class PengeluaranSppDsp extends Model
{
    use HasFactory, SoftDeletes, Blameable;

    protected $fillable = ['name', 'unit_price', 'unit_quantity', 'unit_total_price', 'created_by', 'updated_by', 'deleted_by'];
    protected $table = 't_pengeluaran_spp_dsp';
}
