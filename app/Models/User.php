<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    //Relacion uno a muchos (inversa)
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    //Relacion uno a muchos (inversa)
    public function sucursale()
    {
        return $this->belongsTo(Sucursale::class);
    }
}
