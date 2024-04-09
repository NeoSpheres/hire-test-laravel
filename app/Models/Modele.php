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
        'matricule',
        'color',
        'engine'
    ];

    public function Brand(){
        return $this->hasMany(Brand::class);
    }
    public function Car(){
        return $this->belongsTo(Car::class,'id');
    }
}
