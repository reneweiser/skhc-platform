<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use PhpParser\Node\Expr\Assign;

class Volunteer extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        self::created(function(Volunteer $volunteer) {
            VolunteerVerificationToken::create([
                'volunteer_id' => $volunteer->id
            ]);
        });
    }

    public function assign(array $shiftIds)
    {
        foreach ($shiftIds as $shiftId)
            $this->assignments()->attach($shiftId);
    }

    public function assignments(): BelongsToMany
    {
        return $this->belongsToMany(Shift::class, 'assignments')
            ->using(Assignment::class)
            ->withTimestamps();
    }

    public function verify()
    {
        $this->verified = now();
        $this->save();
    }

    public function verificationToken(): HasOne
    {
        return $this->hasOne(VolunteerVerificationToken::class);
    }
}
