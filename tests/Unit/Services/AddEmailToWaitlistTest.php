<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\AskUserToConfirmInscriptionToWaitlist;
use App\Models\UserWaitlist;
use App\Services\AddEmailToWaitlist;
use Carbon\Carbon;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AddEmailToWaitlistTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_adds_a_user_to_the_waitlist(): void
    {
        Queue::fake();
        Carbon::setTestNow(Carbon::create(2024, 3, 17));

        $email = 'chandler.bing@friends.com';

        $waitlistEntry = (new AddEmailToWaitlist(
            email: $email,
        ))->execute();

        $this->assertDatabaseHas('user_waitlist', [
            'id' => $waitlistEntry->id,
        ]);

        $this->assertEquals('chandler.bing@friends.com', $waitlistEntry->email);
        $this->assertTrue(str()->isUuid($waitlistEntry->confirmation_code));
        $this->assertEquals('subscribed_not_confirmed', $waitlistEntry->status);

        $this->assertInstanceOf(
            UserWaitlist::class,
            $waitlistEntry,
        );

        Queue::assertPushedOn(
            queue: 'low',
            job: AskUserToConfirmInscriptionToWaitlist::class,
            callback: function (AskUserToConfirmInscriptionToWaitlist $job): bool {
                return $job->email === 'chandler.bing@friends.com';
            },
        );
    }

    #[Test]
    public function it_throws_an_exception_if_the_email_is_already_in_the_waitlist(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('User already in waitlist');

        $email = 'joey.tribbiani@friends.com';

        UserWaitlist::factory()->create([
            'email' => $email,
        ]);

        (new AddEmailToWaitlist(
            email: $email,
        ))->execute();
    }
}
