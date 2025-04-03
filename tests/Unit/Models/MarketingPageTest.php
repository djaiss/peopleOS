<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\MarketingPage;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MarketingPageTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_has_many_users(): void
    {
        $marketingPage = MarketingPage::factory()->create();
        $user = User::factory()->create();
        $marketingPage->users()->attach($user);

        $this->assertTrue($marketingPage->users()->exists());
    }
}
