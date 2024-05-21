<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    use HasFactory;

    protected $table = 'modeles';

    protected $fillable = [
        'nomModel',
        'brand_id',
        'engine'
    ];

    public function Brand(){
        return $this->belongsTo(Brand::class,'brand_id');
    }
    public function Car(){
        return $this->hasMany(Car::class,'id');
    }
}
