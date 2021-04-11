<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded=[''];
    
    //Relacion uno a muchos
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
