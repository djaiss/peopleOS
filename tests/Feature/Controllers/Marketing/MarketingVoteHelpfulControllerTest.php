<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Marketing;

use App\Models\MarketingPage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MarketingVoteHelpfulControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_marks_a_page_as_helpful(): void
    {
        $user = User::factory()->create();
        $page = MarketingPage::factory()->create();

        $response = $this->actingAs($user)
            ->from('/some/page')
            ->post('/vote/'.$page->id.'/helpful');

        $response->assertRedirect('/some/page');
        $response->assertSessionHas('hasVoted', true);

        $this->assertDatabaseHas('marketing_page_user', [
            'user_id' => $user->id,
            'marketing_page_id' => $page->id,
            'helpful' => true,
        ]);
    }

    #[Test]
    public function unauthenticated_user_cannot_mark_page_as_helpful(): void
    {
        $page = MarketingPage::factory()->create();

        $response = $this->post('/vote/'.$page->id.'/helpful');

        $response->assertRedirect('/login');

        $this->assertDatabaseMissing('marketing_page_user', [
            'marketing_page_id' => $page->id,
        ]);
    }
}
