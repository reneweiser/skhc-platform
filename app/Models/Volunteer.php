<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use PhpParser\Node\Expr\Assign;

class Volunteer extends Model
{
    use HasFactory;

    public function assign(array $shiftIds)
    {
        $this->assignments()->sync($shiftIds);
        $this->touch();
    }

    public function assignments(): BelongsToMany
    {
        return $this->belongsToMany(ShiftTime::class, 'assignments')
            ->using(Assignment::class)
            ->withTimestamps();
    }

    public function shirtSize(): BelongsTo
    {
        return $this->belongsTo(ShirtSize::class);
    }

    public function verify()
    {
        $this->verified = now();
        $this->save();
    }
}
