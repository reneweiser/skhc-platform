<?php

namespace Tests\Unit;

use App\Mail\VolunteerCreated;
use App\Mail\VolunteerVerified;
use App\Models\Shift;
use App\Models\ShirtSize;
use App\Models\Volunteer;
use App\Models\VolunteerVerificationToken;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SignupTest extends TestCase
{
    use DatabaseMigrations;
    use WithFaker;

    /**
     * @test
     */
    public function it_creates_a_new_volunteer()
    {
        $this->createVolunteer();

        $this->assertDatabaseHas('volunteers', [ 'email' => 'example@test.com' ]);
    }

    /**
     * @test
     */
    public function it_assigns_the_correct_shifts_when_a_volunteer_is_created()
    {
        $this->createVolunteer();

        $this->assertDatabaseHas('assignments', ['volunteer_id' => 1, 'shift_id' => 1]);
    }

    /**
     * @test
     */
    public function it_creates_new_volunteers_without_verifying_them()
    {
        $this->createVolunteer();

        $this->assertNull(Volunteer::first()->verified);
    }

    /**
     * @test
     */
    public function it_creates_a_volunteer_verification_token_when_a_volunteer_is_created()
    {
        $this->createVolunteer();

        $this->assertDatabaseCount('volunteer_verification_tokens', 1);
    }

    /**
     * @test
     */
    public function it_sends_a_verification_mail_when_a_volunteer_is_created()
    {
        Mail::fake();

        $this->createVolunteer();

        Mail::assertSent(VolunteerCreated::class, function($mail) {
            return $mail->hasTo('example@test.com');
        });
    }

    /**
     * @test
     */
    public function it_verifies_a_volunteer_when_visiting_the_url_of_the_token()
    {
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
        Mail::fake();

        $this->createVolunteer();
        $token = VolunteerVerificationToken::first();

        $this->get(route('volunteer.verify', $token));

        Mail::assertSent(VolunteerVerified::class);
    }

    protected function createVolunteer()
    {
        $this->post(route('volunteer.store'), [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => 'example@test.com',
            'mobile' => $this->faker->phoneNumber,
            'shirt_size_id' => ShirtSize::factory()->create()->id,
            'selected_shifts' => [
                Shift::factory()->create()->id
            ]
        ]);
    }
}
