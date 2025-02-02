<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Administration;

use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdministrationPruneAccountControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function administration_prune_can_be_rendered(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/administration/account');

        $response->assertStatus(200);
        $response->assertSee('Prune your account');
    }

    #[Test]
    public function user_can_prune_their_account(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->from('/administration/account')
            ->put('/administration/prune');

        $response->assertRedirect('/administration/account');
        $response->assertSessionHas('status', 'The account has been pruned');
        $this->assertDatabaseMissing('persons', [
            'id' => $person->id,
        ]);
    }

    #[Test]
    public function unauthenticated_user_cannot_prune_account(): void
    {
        $response = $this->put('/administration/prune');

        $response->assertRedirect('/login');
    }
}
