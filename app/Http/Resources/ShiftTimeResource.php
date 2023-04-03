<?php

namespace App\Http\Resources;

use App\Models\Assignment;
use Illuminate\Http\Resources\Json\JsonResource;

class ShiftTimeResource extends JsonResource
{
    public function toArray($request)
    {
        $spotsFilled = Assignment::where('shift_time_id', $this->id)->count();
        return [
            'id' => $this->id,
            'label' => $this->label,
            'volunteers_needed' => $this->volunteers_needed,
            'spots_filled' => $spotsFilled,
            'needs_more_volunteers' => $spotsFilled < $this->volunteers_needed
        ];
    }
}
