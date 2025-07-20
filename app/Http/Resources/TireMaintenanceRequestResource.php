<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TireMaintenanceRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'car_id' => $this->car_id,
            'user_id' => $this->user_id,
            'status' => $this->status->value,
            'maintenance_scheduled_at' => $this->maintenance_scheduled_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'car' => $this->whenLoaded('car', fn () => $this->car->toArray()),
            'user' => $this->whenLoaded('user', fn () => $this->user->toArray()),
            'tires' => TireMaintenanceTireResource::collection($this->whenLoaded('tires')),
        ];
    }
}
