<?php

namespace Tests\Unit;

use App\Mail\VerificationRequested;
use App\Mail\VerificationSuccessful;
use App\Models\EditToken;
use App\Models\ShiftTime;
use App\Models\Volunteer;
use App\Models\VolunteerVerificationToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
        $this->createVolunteer();

        $v = Volunteer::first();
        dd($v->assignments()->pluck('shift_time_id'));
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
