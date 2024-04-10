<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modele extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomModel',
        'idBrand',
        'engine'
    ];

    public function Brand(){
        return $this->belongsTo(Brand::class,'idBrand');
    }
    public function Car(){
        return $this->hasMany(Car::class,'id');
    }
}
