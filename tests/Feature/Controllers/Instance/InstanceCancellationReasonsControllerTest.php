<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Instance;

use App\Models\AccountDeletionReason;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class InstanceCancellationReasonsControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_should_show_cancellation_reasons_to_instance_administrator(): void
    {
        $user = User::factory()->create([
            'is_instance_admin' => true,
        ]);

        AccountDeletionReason::factory()->create([
            'reason' => 'I am not a fan of Central Perk',
        ]);

        $response = $this->actingAs($user)
            ->get('/instance/cancellation-reasons');

        $response->assertOk()
            ->assertSee('I am not a fan of Central Perk');
    }

    #[Test]
    public function it_should_not_show_cancellation_reasons_to_non_instance_administrator(): void
    {
        $user = User::factory()->create([
            'is_instance_admin' => false,
        ]);

        $response = $this->actingAs($user)
            ->get('/instance/cancellation-reasons');

        $response->assertStatus(403);
    }

    #[Test]
    public function it_should_order_cancellation_reasons_by_created_at_desc(): void
    {
        $user = User::factory()->create([
            'is_instance_admin' => true,
        ]);

        AccountDeletionReason::factory()->create([
            'reason' => 'I am not a fan of Central Perk',
            'created_at' => now()->subDays(2),
        ]);

        AccountDeletionReason::factory()->create([
            'reason' => 'I am not a fan of the coffee',
            'created_at' => now(),
        ]);

        $response = $this->actingAs($user)
            ->get('/instance/cancellation-reasons');

        $response->assertOk()
            ->assertSeeInOrder([
                'I am not a fan of the coffee',
                'I am not a fan of Central Perk',
            ]);
    }
}
