<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShiftTime extends Model
{
    use HasFactory;

    public function event(): BelongsTo
    {
        return $this->belongsTo(Shift::class);
    }
}