<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Marketing;

use App\Models\MarketingPage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MarketingVoteUnhelpfulControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_marks_a_page_as_unhelpful(): void
    {
        $user = User::factory()->create();
        $page = MarketingPage::factory()->create();

        $response = $this->actingAs($user)
            ->from('/some/page')
            ->post('/vote/'.$page->id.'/unhelpful');

        $response->assertRedirect('/some/page');
        $response->assertSessionHas('hasVoted', true);

        $this->assertDatabaseHas('marketing_page_user', [
            'user_id' => $user->id,
            'marketing_page_id' => $page->id,
            'helpful' => false,
        ]);

        $this->assertDatabaseHas('marketing_pages', [
            'id' => $page->id,
            'marked_not_helpful' => $page->marked_not_helpful + 1,
        ]);
    }

    #[Test]
    public function unauthenticated_user_cannot_mark_page_as_unhelpful(): void
    {
        $page = MarketingPage::factory()->create();

        $response = $this->post('/vote/'.$page->id.'/unhelpful');

        $response->assertRedirect('/login');

        $this->assertDatabaseMissing('marketing_page_user', [
            'marketing_page_id' => $page->id,
        ]);
    }
}
