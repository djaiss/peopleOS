<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Mail\MagicLinkCreated;
use App\Services\SendMagicLink;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SendMagicLinkTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_queues_a_magic_link_email(): void
    {
        Mail::fake();
        $email = 'test@example.com';
        $url = 'https://example.com/magiclink/abc123';

        $service = new SendMagicLink(
            email: $email,
            url: $url,
        );
        $service->execute();

        Mail::assertQueued(MagicLinkCreated::class, function ($mail) use ($email, $url) {
            return $mail->hasTo($email) &&
                $mail->link === $url &&
                $mail->queue === 'high';
        });
    }

    #[Test]
    public function it_uses_high_priority_queue(): void
    {
        Mail::fake();
        $email = 'test@example.com';
        $url = 'https://example.com/magiclink/abc123';

        (new SendMagicLink(
            email: $email,
            url: $url,
        ))->execute();

        Mail::assertQueued(function (MagicLinkCreated $mail) {
            return $mail->queue === 'high';
        });
    }
}
