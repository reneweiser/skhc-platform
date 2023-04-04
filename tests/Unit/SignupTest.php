<?php

namespace Tests\Unit;

use App\Mail\VerificationRequested;
use App\Mail\VerificationSuccessful;
use App\Models\EditToken;
use App\Models\ShiftTime;
use App\Models\Volunteer;
use App\Models\VolunteerVerificationToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SignupTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_creates_a_new_volunteer()
    {
        $this->seed();
        $this->createVolunteer();

        $this->assertDatabaseHas('volunteers', [ 'email' => 'example@test.com' ]);
    }

    /**
     * @test
     */
    public function it_assigns_the_correct_shifts_when_a_volunteer_is_created()
    {
        $this->seed();
        $this->createVolunteer();

        $this->assertDatabaseHas('assignments', ['volunteer_id' => 1, 'shift_time_id' => 1]);
        $this->assertDatabaseHas('assignments', ['volunteer_id' => 1, 'shift_time_id' => 5]);
    }

    /**
     * @test
     */
    public function it_creates_new_volunteers_without_verifying_them()
    {
        $this->seed();
        $this->createVolunteer();

        $this->assertNull(Volunteer::first()->verified);
    }

    /**
     * @test
     */
    public function it_creates_a_volunteer_verification_token_when_a_volunteer_is_created()
    {
        $this->seed();
        $this->createVolunteer();

        $this->assertDatabaseCount('volunteer_verification_tokens', 1);
    }

    /**
     * @test
     */
    public function it_sends_a_verification_mail_when_a_volunteer_is_created()
    {
        $this->seed();
        Mail::fake();

        $this->createVolunteer();

        Mail::assertSent(VerificationRequested::class, function($mail) {
            return $mail->hasTo('example@test.com');
        });
    }

    /**
     * @test
     */
    public function it_verifies_a_volunteer_when_visiting_the_url_of_the_token()
    {
        $this->seed();
        $this->createVolunteer();
        $token = VolunteerVerificationToken::first();

        $this->get(route('volunteer.verify', $token));

        $this->assertDatabaseCount('volunteer_verification_tokens', 0);
        $this->assertNotNull(Volunteer::first()->verified);
    }

    /**
     * @test
     */
    public function it_sends_a_verification_notice_when_a_volunteer_is_verified()
    {
        $this->seed();
        Mail::fake();

        $this->createVolunteer();
        $token = VolunteerVerificationToken::first();
        $this->get(route('volunteer.verify', $token));

        Mail::assertSent(VerificationSuccessful::class);
    }

    /**
     * @test
     */
    public function it_creates_temporary_access_to_edit_data()
    {
        $this->seed();
        $this->createVolunteer();
        $token = VolunteerVerificationToken::first();
        $this->get(route('volunteer.verify', $token));

        $this->post(route('edit-token.store'), [ 'email' => 'example@test.com' ]);

        $this->assertDatabaseCount('edit_tokens', 1);

        tap(EditToken::first(), function (EditToken $token) {
            $this->assertEquals('example@test.com', $token->email);
            $this->assertNotNull($token->volunteer);
        });
    }

    /**
     * @test
     */
    public function it_shows_assignments()
    {
        $this->seed();
        Volunteer::factory()->count(5)->create()->each(function (Volunteer $volunteer) {
            $shiftIds = fake()->randomElements(ShiftTime::pluck('id'), fake()->numberBetween(1, 5));
            $volunteer->assign($shiftIds);
        });

        $res = DB::table('volunteers')
            ->join('assignments', 'volunteers.id', '=', 'assignments.volunteer_id')
            ->join('shift_times', 'shift_times.id', '=', 'assignments.shift_time_id')
            ->join('shirt_sizes', 'shirt_sizes.id', '=', 'volunteers.shirt_size_id')
            ->join('shifts', 'shifts.id', '=', 'shift_times.shift_id')
            ->select([
                'volunteers.first_name',
                'volunteers.last_name',
                'volunteers.email',
                'volunteers.mobile',
                'shirt_sizes.name as shirt_size',
                'shifts.name as shift_name',
                'shifts.meeting_place',
                'shift_times.label',
            ])
            ->get()
            ->map(fn ($item) => (array)$item)
            ->reduce(function (string $acc, $curr) {
                $acc .= implode(';', $curr);
                $acc .= "\n\r";
                return $acc;
            }, '');
        dd($res);
    }

    protected function createVolunteer()
    {
        $this->post(route('volunteer.store'), [
            'first_name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'email' => 'example@test.com',
            'mobile' => fake()->phoneNumber,
            'shirt_size_id' => fake()->numberBetween(1, 7),
            'selected_shifts' => [1,5]
        ]);
    }
}
