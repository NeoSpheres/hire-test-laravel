<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CarModel extends Model
{
    use HasFactory;

    protected $table = 'modeles';

    protected $fillable = [
        'nomModel',
        'brand_id',
        'engine_type_id'
    ];

    public function Brand(){
        return $this->belongsTo(Brand::class,'brand_id');
    }
    public function Car(){
        return $this->hasMany(Car::class,'id');
    }

    public function engineType(): BelongsTo
    {
        return $this->belongsTo(EngineType::class);
    }
}
