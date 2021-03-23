<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modifier extends Model
{
    use HasFactory;

    //relacion muchos a muchos
    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }
}
