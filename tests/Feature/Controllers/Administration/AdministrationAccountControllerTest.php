<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Administration;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdministrationAccountControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function administration_account_index_can_be_rendered(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/administration/account');

        $response->assertStatus(200);
    }

    #[Test]
    public function user_can_destroy_their_account(): void
    {
        Queue::fake();

        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->from('/administration/account')
            ->delete('/administration/account', [
                'feedback' => 'Moving to a new city',
            ]);

        $response->assertRedirect('/login');

        $this->assertDatabaseMissing('accounts', [
            'id' => $user->account_id,
        ]);
    }
}
