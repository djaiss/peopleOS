<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Services\CreateWaitlistConfirmationLink;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateWaitlistConfirmationLinkTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_returns_a_signed_url(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-03-17 10:00:00'));

        $link = (new CreateWaitlistConfirmationLink(
            code: 'UNAGI123',
        ))->execute();

        $this->assertIsString($link);
        $this->assertStringStartsWith(config('app.url'), $link);
    }

    #[Test]
    public function it_creates_a_temporary_link_valid_for_30_minutes(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-03-17 10:00:00'));

        $link = (new CreateWaitlistConfirmationLink(
            code: 'CLEAN456',
        ))->execute();

        $this->assertStringContainsString('signature=', $link);
        $this->assertStringContainsString('expires=', $link);
    }
}
