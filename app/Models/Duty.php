<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Duty extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }
}
