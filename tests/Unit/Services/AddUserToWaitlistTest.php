<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Models\UserWaitlist;
use App\Services\AddUserToWaitlist;
use Carbon\Carbon;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AddUserToWaitlistTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_adds_a_user_to_the_waitlist(): void
    {
        Carbon::setTestNow(Carbon::create(2024, 3, 17));

        $email = 'chandler.bing@friends.com';

        $waitlistEntry = (new AddUserToWaitlist(
            email: $email,
        ))->execute();

        $this->assertDatabaseHas('user_waitlist', [
            'id' => $waitlistEntry->id,
            'email' => $email,
        ]);

        $this->assertInstanceOf(
            UserWaitlist::class,
            $waitlistEntry
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

        (new AddUserToWaitlist(
            email: $email,
        ))->execute();
    }
}
