<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'model_id',
        'user_id',
        'color',
        'matricule'
    ];

    public function modele()
    {
        return $this->belongsTo(CarModel::class, 'model_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
