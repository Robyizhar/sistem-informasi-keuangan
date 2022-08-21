<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengeluaranSppDsp extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'unit_price', 'unit_quantity', 'unit_total_price'];

}
