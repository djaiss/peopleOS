<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Marketing;

use App\Models\MarketingPage;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MarketingVoteControllerTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_destroys_a_marketing_vote(): void
    {
        $user = User::factory()->create();
        $page = MarketingPage::factory()->create([
            'marked_helpful' => 1,
        ]);

        $user->marketingPages()->attach($page->id, [
            'helpful' => true,
        ]);

        $response = $this->actingAs($user)
            ->from('/some/page')
            ->delete('/vote/' . $page->id);

        $response->assertRedirect('/some/page');

        $this->assertDatabaseMissing('marketing_page_user', [
            'user_id' => $user->id,
            'marketing_page_id' => $page->id,
        ]);

        $this->assertEquals(0, $page->fresh()->marked_helpful);
    }

    #[Test]
    public function unauthenticated_user_cannot_destroy_vote(): void
    {
        $page = MarketingPage::factory()->create();

        $response = $this->delete('/vote/' . $page->id);

        $response->assertRedirect('/login');

        $this->assertDatabaseMissing('marketing_page_user', [
            'marketing_page_id' => $page->id,
        ]);
    }
}
