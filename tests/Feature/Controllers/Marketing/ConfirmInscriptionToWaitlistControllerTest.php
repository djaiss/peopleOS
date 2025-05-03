<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Marketing;

use App\Models\UserWaitlist;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\URL;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ConfirmInscriptionToWaitlistControllerTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_confirms_the_inscription_to_the_waitlist_and_displays_confirmation_page(): void
    {
        $userWaitlist = UserWaitlist::factory()->create([
            'confirmation_code' => '747d560d-8d38-487f-9067-769f77a5bc5e',
            'confirmed_at' => null,
        ]);

        $url = URL::signedRoute('waitlist.confirm', [
            'code' => $userWaitlist->confirmation_code,
        ]);

        $response = $this->get($url);

        $response->assertStatus(200);
        $response->assertViewIs('marketing.waitlist.confirmation');

        $this->assertTrue($userWaitlist->fresh()->confirmed_at);
    }

    #[Test]
    public function it_rejects_requests_with_invalid_signature(): void
    {
        $url = URL::signedRoute('waitlist.confirm', [
            'code' => 'invalid-code',
        ]);

        $response = $this->get($url);
        $response->assertStatus(302);
    }
}
