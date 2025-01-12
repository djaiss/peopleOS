<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Administration;

use App\Livewire\Administration\ListLogs;
use App\Models\Log;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ListLogsTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function the_component_renders(): void
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(ListLogs::class);

        $component->assertOk();
    }

    #[Test]
    public function it_shows_logs_for_the_authenticated_user(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create([
            'first_name' => 'Dwight',
            'last_name' => 'Schrute',
        ]);

        Log::factory()->create([
            'user_id' => $user->id,
            'user_name' => 'Dwight Schrute',
            'action' => 'account_creation',
            'description' => 'Created an account',
        ]);

        $component = Livewire::actingAs($user)
            ->test(ListLogs::class);

        $component->assertSet('logs', collect([
            [
                'user' => [
                    'name' => 'Dwight Schrute',
                ],
                'action' => 'account_creation',
                'description' => 'Created an account',
                'created_at' => '0 seconds ago',
            ],
        ]));
    }

    #[Test]
    public function it_limits_to_five_logs(): void
    {
        $user = User::factory()->create();
        Log::factory()->count(7)->create([
            'user_id' => $user->id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ListLogs::class);

        $this->assertCount(5, $component->get('logs'));
        $component->assertSet('has_more_logs', true);
    }

    #[Test]
    public function it_shows_no_more_logs_indicator_when_five_or_fewer_logs(): void
    {
        $user = User::factory()->create();
        Log::factory()->count(4)->create([
            'user_id' => $user->id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ListLogs::class);

        $this->assertCount(4, $component->get('logs'));
        $component->assertSet('has_more_logs', false);
    }

    #[Test]
    public function it_refreshes_logs_when_avatar_updated_event_is_emitted(): void
    {
        $user = User::factory()->create();
        Log::factory()->create([
            'user_id' => $user->id,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ListLogs::class);

        // Create a new log after initial load
        Log::factory()->create([
            'user_id' => $user->id,
        ]);

        // Emit the avatar-updated event
        $component->dispatch('avatar-updated');

        // Should now have 2 logs in the collection
        $this->assertCount(2, $component->get('logs'));
    }
}
