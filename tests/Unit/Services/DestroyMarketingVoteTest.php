<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\MarketingPage;
use App\Models\User;
use App\Services\DestroyMarketingVote;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DestroyMarketingVoteTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_should_delete_helpful_vote_and_decrement_counter(): void
    {
        $user = User::factory()->create();
        $marketingPage = MarketingPage::factory()->create([
            'marked_helpful' => 1,
        ]);

        $user->marketingPages()->attach($marketingPage->id, [
            'helpful' => true,
        ]);

        (new DestroyMarketingVote(
            user: $user,
            marketingPage: $marketingPage
        ))->execute();

        $this->assertDatabaseMissing('marketing_page_user', [
            'user_id' => $user->id,
            'marketing_page_id' => $marketingPage->id,
            'helpful' => true,
        ]);

        $this->assertEquals(0, $marketingPage->fresh()->marked_helpful);
    }

    #[Test]
    public function it_should_delete_unhelpful_vote_and_decrement_counter(): void
    {
        $user = User::factory()->create();
        $marketingPage = MarketingPage::factory()->create([
            'marked_not_helpful' => 1,
        ]);

        $user->marketingPages()->attach($marketingPage->id, [
            'helpful' => false,
        ]);

        (new DestroyMarketingVote(
            user: $user,
            marketingPage: $marketingPage
        ))->execute();

        $this->assertDatabaseMissing('marketing_page_user', [
            'user_id' => $user->id,
            'marketing_page_id' => $marketingPage->id,
            'helpful' => false,
        ]);

        $this->assertEquals(0, $marketingPage->fresh()->marked_not_helpful);
    }

    #[Test]
    public function it_should_do_nothing_when_no_vote_exists(): void
    {
        $user = User::factory()->create();
        $marketingPage = MarketingPage::factory()->create([
            'marked_helpful' => 0,
            'marked_not_helpful' => 0,
        ]);

        (new DestroyMarketingVote(
            user: $user,
            marketingPage: $marketingPage
        ))->execute();

        $this->assertEquals(0, $marketingPage->fresh()->marked_helpful);
        $this->assertEquals(0, $marketingPage->fresh()->marked_not_helpful);
    }
}
