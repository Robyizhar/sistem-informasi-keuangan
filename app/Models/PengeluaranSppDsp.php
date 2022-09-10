<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PengeluaranSppDsp extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'unit_price', 'unit_quantity', 'unit_total_price'];
    protected $table = 't_pengeluaran_spp_dsp';
}
