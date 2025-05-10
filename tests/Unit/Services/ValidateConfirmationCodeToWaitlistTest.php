<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\UserWaitlist;
use App\Services\ValidateConfirmationCodeToWaitlist;
use Carbon\Carbon;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ValidateConfirmationCodeToWaitlistTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_validates_and_confirms_a_waitlist_entry()
    {
        Carbon::setTestNow(Carbon::parse('2025-03-17'));

        $waitlist = UserWaitlist::factory()->create([
            'confirmation_code' => 'MY-SANDWICH',
            'confirmed_at' => null,
        ]);

        (new ValidateConfirmationCodeToWaitlist(
            code: 'MY-SANDWICH'
        ))->execute();

        $this->assertEquals(
            '2025-03-17 00:00:00',
            $waitlist->fresh()->confirmed_at->format('Y-m-d H:i:s')
        );

        $this->assertEquals(
            'subscribed_and_confirmed',
            $waitlist->fresh()->status
        );
    }

    #[Test]
    public function it_throws_an_exception_when_code_is_invalid()
    {
        UserWaitlist::factory()->create([
            'confirmation_code' => 'CORRECT-PIN',
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid confirmation code');

        (new ValidateConfirmationCodeToWaitlist(
            code: 'WRONG-PIN'
        ))->execute();
    }

    #[Test]
    public function it_throws_an_exception_when_already_confirmed()
    {
        UserWaitlist::factory()->create([
            'confirmation_code' => 'SMELLY-CAT',
            'confirmed_at' => now(),
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('User already confirmed');

        (new ValidateConfirmationCodeToWaitlist(
            code: 'SMELLY-CAT'
        ))->execute();
    }
}
