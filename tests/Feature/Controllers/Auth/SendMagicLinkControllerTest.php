<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SendMagicLinkControllerTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_displays_the_magic_link_request_form(): void
    {
        $response = $this->get(route('magic.link'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.request-magic-link');
    }

    #[Test]
    public function it_sends_magic_link_when_user_exists(): void
    {
        User::factory()->create([
            'email' => 'chandler.bing@example.com',
        ]);

        $response = $this->json('POST', route('magic.link.store'), [
            'email' => 'chandler.bing@example.com',
        ]);

        $response->assertStatus(200);
        $response->assertViewIs('auth.magic-link-sent');
    }

    #[Test]
    public function it_shows_success_view_even_when_user_not_found(): void
    {
        $response = $this->json('POST', route('magic.link.store'), [
            'email' => 'not.found@example.com',
        ]);

        $response->assertStatus(200);
        $response->assertViewIs('auth.magic-link-sent');
    }

    #[Test]
    public function it_validates_email_presence(): void
    {
        $response = $this->json('POST', route('magic.link.store'), [
            'email' => '',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    #[Test]
    public function it_validates_email_format(): void
    {
        $response = $this->json('POST', route('magic.link.store'), [
            'email' => 'not-an-email',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }
}
