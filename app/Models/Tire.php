<?php

namespace App\Models;

use App\Enums\TireMaintenance\TireMaintenanceRequestStatusEnum;
use App\Models\TireMaintenance\TireMaintenanceRequestTire;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Tire extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand',
        'model',
        'type',
    ];


    protected function brand(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
        );
    }

    protected function model(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
        );
    }

    protected function getFullTireNameAttribute(): string
    {
        return $this->brand . " / " . $this->model . " / " . ucfirst($this->type);
    }

    public function carFrontTire(): HasMany
    {
        return $this->hasMany(Car::class, "front_tire_id");
    }

    public function carRearTire(): HasMany
    {
        return $this->hasMany(Car::class, "rear_tire_id");
    }

    /**
     * @return HasManyThrough
     */
    public function tireReplacements(): HasManyThrough
    {
        return $this->hasManyThrough(
            Tire::class,
            TireMaintenanceRequestTire::class,
            'tire_maintenance_request_id',
            'id',
            'id',
            'tire_id'
        )->whereHas('tire_maintenance_request', function ($query) {
            $query->where('status', TireMaintenanceRequestStatusEnum::COMPLETED);
        });
    }
}
