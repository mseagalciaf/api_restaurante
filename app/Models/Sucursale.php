<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursale extends Model
{
    use HasFactory;

    //Relacion uno a uno (inversa)
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    //Relacion uno a uno 
    public function user()
    {
        return $this->hasMany(User::class);
    }

    //Relacion muchos a muchos
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
