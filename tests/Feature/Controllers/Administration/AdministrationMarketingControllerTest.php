<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Administration;

use App\Models\Log;
use App\Models\MarketingPage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdministrationMarketingControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_shows_the_marketing_information_in_the_user_settings_page(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create([
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);

        $page = MarketingPage::factory()->create();
        $page->users()->attach($user->id, [
            'helpful' => true,
            'comment' => 'This is a comment',
            'updated_at' => Carbon::now(),
        ]);

        $response = $this->actingAs($user)
            ->get('/administration/marketing');

        $response->assertStatus(200);
        $response->assertViewIs('administration.marketing.index');
        $this->assertArrayHasKey('marketingPages', $response);
    }

    #[Test]
    public function user_can_delete_an_activity_made_on_a_page(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create([
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);

        $page = MarketingPage::factory()->create();
        $page->users()->attach($user->id, [
            'helpful' => true,
            'comment' => 'This is a comment',
            'updated_at' => Carbon::now(),
        ]);

        $response = $this->actingAs($user)
            ->delete('/administration/marketing/'.$page->id);

        $response->assertStatus(302);
    }
}
