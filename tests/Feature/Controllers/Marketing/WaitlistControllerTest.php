<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Marketing;

use App\Models\UserWaitlist;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class WaitlistControllerTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_shows_the_subscribe_page(): void
    {
        $response = $this->get(route('waitlist.index'));

        $response->assertStatus(200);
        $response->assertViewIs('marketing.waitlist.subscribe');
    }

    #[Test]
    public function it_adds_an_email_to_the_waitlist_and_shows_waiting_page(): void
    {
        $email = 'phoebe.buffay@example.com';

        $response = $this->post(route('waitlist.store'), [
            'email' => $email,
        ]);

        $response->assertStatus(200);
        $response->assertViewIs('marketing.waitlist.waiting');
    }

    #[Test]
    public function it_rejects_request_without_email(): void
    {
        $response = $this->post(route('waitlist.store'), [
            'email' => '',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['email']);
        $this->assertDatabaseCount('user_waitlist', 0);
    }

    #[Test]
    public function it_rejects_request_with_invalid_email(): void
    {
        $response = $this->post(route('waitlist.store'), [
            'email' => 'invalid-email',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['email']);
        $this->assertDatabaseCount('user_waitlist', 0);
    }

    #[Test]
    public function it_rejects_request_with_duplicate_email(): void
    {
        $existingUser = UserWaitlist::factory()->create([
            'email' => 'monica.geller@example.com',
        ]);

        $response = $this->post(route('waitlist.store'), [
            'email' => $existingUser->email,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['email']);
        $this->assertDatabaseCount('user_waitlist', 1);
    }
}
