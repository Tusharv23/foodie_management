<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $fillable = ['name','cuisine','type','spice_level'];
    protected $visible = ['name','cuisine','type','spice_level'];

    protected $table = 'food';
}
