<?php

declare(strict_types=1);

namespace Tests\Unit\Jobs;

use App\Jobs\AskUserToConfirmInscriptionToWaitlist;
use App\Mail\InscriptionToWaitlistRequired;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AskUserToConfirmInscriptionToWaitlistTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_sends_the_confirmation_email(): void
    {
        Mail::fake();
        Carbon::setTestNow(Carbon::create(2024, 3, 17));

        $email = 'rachel.green@friends.com';
        $link = 'https://example.com/confirmation/123e4567-e89b-12d3-a456-426614174000';

        (new AskUserToConfirmInscriptionToWaitlist(
            email: $email,
            link: $link,
        ))->handle();

        Mail::assertQueued(
            InscriptionToWaitlistRequired::class,
            function (InscriptionToWaitlistRequired $mail) use ($link): bool {
                return $mail->link === $link;
            },
        );
    }
}
