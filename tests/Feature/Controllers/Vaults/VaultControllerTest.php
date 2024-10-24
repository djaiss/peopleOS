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
    public function a_user_can_create_a_vault(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/new', [
                'name' => 'Super vault',
                'description' => 'this is the description',
            ])
            ->assertRedirectToRoute('vaults.show', ['vault' => Vault::first()]);
    }

    #[Test]
    public function a_user_can_delete_a_vault(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);

        $this->actingAs($user)
            ->delete('/vaults/'.$vault->id)
            ->assertRedirectToRoute('vaults.index');
    }
}
