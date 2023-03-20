<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ShiftResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'description' => Str::markdown($this->description),
            'name' => $this->name,
            'event_name' => $this->event->name,
            'times' => ShiftTimeResource::collection($this->shiftTimes)
        ];
    }
}
