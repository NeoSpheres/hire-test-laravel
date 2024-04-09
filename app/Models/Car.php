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
        'pays'
    ];

    public function modele()
    {
        return $this->belongsTo(Modele::class, 'id_model');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
