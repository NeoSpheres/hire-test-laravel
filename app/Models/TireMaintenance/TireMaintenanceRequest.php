<?php

declare(strict_types=1);

namespace App\Models\TireMaintenance;

use App\Enums\TireMaintenance\TireMaintenanceRequestStatusEnum;
use App\Models\Car;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TireMaintenanceRequest extends Model
{
    /**
     * @var \class-string[]
     */
    protected $casts = [
        'status' => TireMaintenanceRequestStatusEnum::class,
        'maintenance_scheduled_at' => 'date',
    ];

    /**
     * @return BelongsTo
     */
    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany
     */
    public function tires(): HasMany
    {
        return $this->hasMany(TireMaintenanceRequestTire::class);
    }
}
