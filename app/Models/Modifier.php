<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modifier extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    
    //relacion muchos a muchos
    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }
}
