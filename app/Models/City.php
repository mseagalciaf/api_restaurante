<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    //Relacion uno a uno 
    public function sucursale()
    {
        return $this->hasOne(Sucursale::class);
    }
}
