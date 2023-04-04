<?php

namespace App\Mail;

use App\Models\Volunteer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class VolunteerUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public Volunteer $volunteer;
    public Collection $assignments;
    public string $createEditTokenRoute;

    public function __construct(Volunteer $volunteer)
    {
        $this->volunteer = $volunteer;
        $this->createEditTokenRoute = route('edit-token.create');
        $this->assignments = DB::table('assignments')->where('volunteer_id', $volunteer->id)
            ->join('shift_times', 'assignments.shift_time_id', '=', 'shift_times.id')
            ->join('shifts', 'shift_times.shift_id', '=', 'shifts.id')
            ->join('events', 'shifts.event_id', '=', 'events.id')
            ->select('shift_times.label', 'shifts.meeting_place', 'shifts.name as shift_name', 'events.name as event_name')
            ->get();
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Du hast deine Daten erfolgreich geändert',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.volunteers.updated',
        );
    }
}
