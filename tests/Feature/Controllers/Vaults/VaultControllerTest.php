<?php

namespace Tests\Feature\Controllers\Vaults;

use App\Models\User;
use App\Models\Vault;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class VaultControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_shows_an_empty_dashboard_upon_account_creation(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/')
            ->assertSee('Thanks for');
    }

    #[Test]
    public function a_user_can_create_a_vault(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/')
            ->assertSee('henri');

        $this->actingAs($user)
            ->post('/new', [
                'name' => 'Super vault',
                'description' => 'this is the description',
            ])
            ->assertRedirectToRoute('vaults.show', ['vault' => Vault::first()]);
    }
}
