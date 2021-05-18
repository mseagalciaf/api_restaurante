<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded=[''];

    //Relacion uno a muchos (inversa)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    //Relacion muchos a muchos
    public function sucursales()
    {
        return $this->belongsToMany(Sucursale::class)->withPivot('activated');
    }

    //Relacion muchos a muchos
    public function sales()
    {
        return $this->belongsToMany(Sale::class);
    }

    //Relacion muchos a muchos
    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }
}
