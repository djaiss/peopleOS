<?php

declare(strict_types=1);

namespace Tests\Unit\Jobs;

use App\Jobs\SendMagicLinkToLogin;
use App\Mail\MagicLinkCreated;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SendMagicLinkToLoginTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_sends_a_link_to_login(): void
    {
        Mail::fake();

        User::factory()->create([
            'email' => 'ross.geller@friends.com',
        ]);

        SendMagicLinkToLogin::dispatch(
            email: 'ross.geller@friends.com',
            url: 'https://example.com/magiclink/abc123',
        );

        Mail::assertQueued(MagicLinkCreated::class, function (MagicLinkCreated $mail): bool {
            return $mail->hasTo('ross.geller@friends.com') &&
                $mail->link === 'https://example.com/magiclink/abc123' &&
                $mail->queue === 'high';
        });
    }

    #[Test]
    public function it_does_not_send_an_email_if_the_user_does_not_exist(): void
    {
        Mail::fake();

        SendMagicLinkToLogin::dispatch(
            email: 'ross.geller@friends.com',
            url: 'https://example.com/magiclink/abc123',
        );

        Mail::assertNotQueued(MagicLinkCreated::class);
    }
}
