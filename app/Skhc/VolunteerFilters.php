<?php

namespace App\Skhc;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class VolunteerFilters
{
    public static function volunteerInfo(): Collection
    {
        return DB::table('volunteers')
            ->join('assignments', 'volunteers.id', '=', 'assignments.volunteer_id')
            ->join('shift_times', 'shift_times.id', '=', 'assignments.shift_time_id')
            ->join('shirt_sizes', 'shirt_sizes.id', '=', 'volunteers.shirt_size_id')
            ->join('shifts', 'shifts.id', '=', 'shift_times.shift_id')
            ->select([
                'volunteers.first_name',
                'volunteers.last_name',
                'volunteers.email',
                'volunteers.mobile',
                'volunteers.verified',
                'shirt_sizes.name as shirt_size',
                'shifts.name as shift_name',
                'shifts.meeting_place',
                'shift_times.label',
                'assignments.created_at',
            ])
            ->orderByDesc('assignments.created_at')
            ->get();
    }

    public static function shirtShoppingList(): Collection
    {
        return DB::table('volunteers')
            ->join('shirt_sizes', 'volunteers.shirt_size_id', '=', 'shirt_sizes.id')
            ->select('shirt_sizes.name', DB::raw('count(*) as total'))
            ->groupBy('shirt_size_id')
            ->get();
    }

    public static function spots(): Collection
    {
        return DB::table('shift_times')
            ->join('assignments', 'assignments.shift_time_id', '=', 'shift_times.id')
            ->select('shift_times.id as shift_time_id', 'volunteers_needed', DB::raw('count(*) as signed_up'))
            ->groupBy('shift_time_id')
            ->get();
    }

    public static function openSpots(): Collection
    {
        return DB::table('shift_times')
            ->leftJoin('assignments', 'assignments.shift_time_id', '=', 'shift_times.id')
            ->join('shifts', 'shift_times.shift_id', '=', 'shifts.id')
            ->join('events', 'shifts.event_id', '=', 'events.id')
            ->select(
                'shift_times.id AS shift_time_id',
                'shift_times.label AS shift_time',
                'shift_times.volunteers_needed',
                'shifts.name AS shift_name',
                'events.name AS event_name',
                DB::raw('COUNT(assignments.shift_time_id) AS spots_filled')
            )
            ->groupBy('shift_times.id')
            ->get()
            ->map(function ($spot) {
                $spot->remaining = $spot->volunteers_needed - $spot->spots_filled;
                $spot->filledPercent = $spot->spots_filled === 0
                    ? 0
                    : round($spot->spots_filled / $spot->volunteers_needed * 100, 1);
                return $spot;
            });
    }
}
