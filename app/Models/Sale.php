<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    //Relacion muchos a muchos
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }  
}
