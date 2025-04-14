<?php

declare(strict_types=1);

namespace Tests\Unit\Jobs;

use App\Jobs\SendAPICreatedEmail;
use App\Jobs\SendAPIDesrtroyedEmail;
use App\Mail\ApiKeyCreated;
use App\Mail\ApiKeyDestroyed;
use App\Mail\LoginFailed;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SendAPIDestroyedEmailTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_sends_an_email_to_the_user_if_the_api_is_destroyed(): void
    {
        Mail::fake();

        User::factory()->create([
            'email' => 'ross.geller@friends.com',
        ]);

        SendAPIDesrtroyedEmail::dispatch(
            email: 'ross.geller@friends.com',
            label: 'API Key',
        );

        Mail::assertQueued(ApiKeyDestroyed::class, function (ApiKeyDestroyed $mail): bool {
            return $mail->hasTo('ross.geller@friends.com') &&
                $mail->queue === 'high';
        });
    }

    #[Test]
    public function it_does_not_send_an_email_if_the_user_does_not_exist(): void
    {
        Mail::fake();

        SendAPIDesrtroyedEmail::dispatch(
            email: 'ross.geller@friends.com',
            label: 'API Key',
        );

        Mail::assertNotQueued(ApiKeyDestroyed::class);
    }
}
