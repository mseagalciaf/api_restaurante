<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable=['name'];

    //Relacion muchos a muchos
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    //Relacion muchos a muchos
    public function modifiers()
    {
        return $this->belongsToMany(Modifier::class);
    }
}
