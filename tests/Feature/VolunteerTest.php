<?php

namespace Tests\Feature;

use App\Mail\VerificationRequested;
use App\Mail\VerificationSuccessful;
use App\Mail\VolunteerEditRequested;
use App\Models\EditToken;
use App\Models\Volunteer;
use App\Models\VolunteerVerificationToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class VolunteerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function createVolunteer(string $email): TestResponse
    {
        $this->seed();

        return $this->followingRedirects()->post('/volunteers', [
            'first_name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'email' => $email,
            'mobile' => fake()->phoneNumber,
            'shirt_size_id' => fake()->numberBetween(1, 7),
            'selected_shifts' => fake()->randomElements([1, 2, 3, 4, 5, 6, 7, 8], 4)
        ]);
    }

    /**
     * @test
     */
    public function it_creates_a_new_volunteer()
    {
        $email = fake()->email;
        $this->createVolunteer($email);

        $this->assertDatabaseCount('volunteers', 1);
    }

    /**
     * @test
     */
    public function it_shows_a_volunteer_created_notice_after_creating_a_volunteer()
    {
        $email = fake()->email;
        $response = $this->createVolunteer($email);

        $response->assertSee($email);
    }

    /**
     * @test
     */
    public function it_sends_an_email_after_creating_a_volunteer()
    {
        Mail::fake();

        $email = fake()->email;
        $this->createVolunteer($email);

        Mail::assertSent(VerificationRequested::class);
    }

    /**
     * @test
     */
    public function it_verifies_a_volunteer_after_using_the_correct_token()
    {
        Mail::fake();
        $email = fake()->email;
        $this->createVolunteer($email);

        $this->assertDatabaseHas('volunteers', ['email' => $email, 'verified' => null]);
        $this->assertDatabaseHas('volunteer_verification_tokens', ['volunteer_id' => 1]);

        $token = VolunteerVerificationToken::where('volunteer_id', 1)->first();

        $this->get(route('volunteer.verify', $token));

        $this->assertDatabaseHas('volunteers', ['email' => $email, 'verified' => now()]);
    }

    /**
     * @test
     */
    public function it_sends_an_email_after_successfully_verifying_a_volunteer()
    {
        Mail::fake();
        $email = fake()->email;
        $this->createVolunteer($email);

        $token = VolunteerVerificationToken::where('volunteer_id', 1)->first();
        $this->get(route('volunteer.verify', $token));

        Mail::assertSent(VerificationSuccessful::class);
    }

    /**
     * @test
     */
    public function it_creates_an_edit_token()
    {
        $this->createVolunteer(fake()->email);

        $volunteer = Volunteer::first();

        $this->post('/edit-tokens', [ 'email' => $volunteer->email ]);

        $this->assertDatabaseHas('edit_tokens', ['email' => $volunteer->email]);
    }

    /**
     * @test
     */
    public function it_sends_an_email_after_creating_an_edit_token()
    {
        Mail::fake();

        $this->createVolunteer(fake()->email);

        $volunteer = Volunteer::first();

        $this->post('/edit-tokens', [ 'email' => $volunteer->email ]);

        Mail::assertSent(VolunteerEditRequested::class);
    }

    /**
     * @test
     */
    public function it_shows_an_edit_form_when_visiting_the_edit_route_using_the_edit_token()
    {
        $this->createVolunteer(fake()->email);

        $volunteer = Volunteer::first();

        $this->post('/edit-tokens', [ 'email' => $volunteer->email ]);

        $token = EditToken::first();

        $response = $this->get(route('volunteer.edit', $token));

        $response->assertSee('Daten für ' . $volunteer->first_name . ' ändern');
    }
}
