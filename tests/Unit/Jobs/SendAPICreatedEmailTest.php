<?php

declare(strict_types=1);

namespace Tests\Unit\Jobs;

use App\Enums\EmailType;
use App\Jobs\SendAPICreatedEmail;
use App\Mail\ApiKeyCreated;
use App\Models\EmailSent;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SendAPICreatedEmailTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_sends_an_email_to_the_user_if_there_is_an_api_key_creation(): void
    {
        Mail::fake();

        User::factory()->create([
            'email' => 'ross.geller@friends.com',
        ]);

        SendAPICreatedEmail::dispatch(
            email: 'ross.geller@friends.com',
            label: 'API Key',
        );

        Mail::assertQueued(ApiKeyCreated::class, function (ApiKeyCreated $mail): bool {
            return $mail->hasTo('ross.geller@friends.com') &&
                $mail->queue === 'high';
        });

        $emailSent = EmailSent::latest()->first();

        $this->assertEquals(EmailType::API_CREATED->value, $emailSent->email_type);
        $this->assertEquals('ross.geller@friends.com', $emailSent->email_address);
        $this->assertEquals('New API key added', $emailSent->subject);
    }

    #[Test]
    public function it_does_not_send_an_email_if_the_user_does_not_exist(): void
    {
        Mail::fake();

        SendAPICreatedEmail::dispatch(
            email: 'ross.geller@friends.com',
            label: 'API Key',
        );

        Mail::assertNotQueued(ApiKeyCreated::class);
    }
}
