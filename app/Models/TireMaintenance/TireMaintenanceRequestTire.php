<?php

declare(strict_types=1);

namespace App\Models\TireMaintenance;

use App\Enums\TireMaintenance\TirePositionEnum;
use App\Models\Tire;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TireMaintenanceRequestTire extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'tire_maintenance_request_id',
        'tire_id',
        'position'
    ];

    /**
     * @var \class-string[]
     */
    protected $casts = [
        'position' => TirePositionEnum::class
    ];

    /**
     * @return BelongsTo
     */
    public function tire(): BelongsTo
    {
        return $this->belongsTo(Tire::class);
    }

    /**
     * @return BelongsTo
     */
    public function tire_maintenance_request(): BelongsTo
    {
        return $this->belongsTo(TireMaintenanceRequest::class);
    }
}
