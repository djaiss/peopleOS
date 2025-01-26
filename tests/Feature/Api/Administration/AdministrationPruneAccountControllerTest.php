<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Administration;

use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdministrationPruneAccountControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_can_prune_their_account(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/administration/prune');

        $response->assertStatus(204);

        $this->assertDatabaseMissing('persons', [
            'id' => $person->id,
        ]);
    }

    #[Test]
    public function unauthenticated_user_cannot_prune_account(): void
    {
        $response = $this->json('PUT', '/api/administration/prune');

        $response->assertStatus(401);
    }
}
