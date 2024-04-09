<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modele extends Model
{
    use HasFactory;
    public function Brand(){
        return $this->belongsTo(Brand::class);
    }

    public function Car(){
        return $this->hasMany(Car::class);
    }
}
