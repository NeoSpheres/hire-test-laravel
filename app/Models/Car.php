<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'model_id',
        'user_id',
        'color',
        'matricule',
        'front_tire_id',
        'rear_tire_id',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'last_maintenance_date' => 'datetime',
    ];

    public function modele()
    {
        return $this->belongsTo(CarModel::class, 'model_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function frontTire(): BelongsTo
    {
        return $this->belongsTo(Tire::class);
    }

    public function rearTire(): BelongsTo
    {
        return $this->belongsTo(Tire::class);
    }
}
