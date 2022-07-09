<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu_items extends Model
{
    use HasFactory;
    protected $table="menu_items";
    protected $fillable=['label','link','parent','sort','class','menu','depth'];
}
