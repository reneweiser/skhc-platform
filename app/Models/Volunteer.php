<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use PhpParser\Node\Expr\Assign;

class Volunteer extends Model
{
    use HasFactory;

    public function assign(array $dutyIds)
    {
        foreach ($dutyIds as $dutyId)
            $this->assignments()->attach($dutyId);
    }

    public function assignments(): BelongsToMany
    {
        return $this->belongsToMany(Duty::class, 'assignments')
            ->using(Assignment::class)
            ->withTimestamps();
    }
}
