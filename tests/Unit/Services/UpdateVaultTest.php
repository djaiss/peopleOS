<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Models\Vault;
use App\Services\UpdateVault;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateVaultTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_a_vault(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);

        $this->executeService($user, $vault);
    }

    #[Test]
    public function it_fails_if_vault_doesnt_belong_to_account(): void
    {
        $user = User::factory()->create();
        $vault = Vault::factory()->create();

        $this->expectException(ModelNotFoundException::class);
        $this->executeService($user, $vault);
    }

    private function executeService(User $user, Vault $vault): void
    {
        $vault = (new UpdateVault(
            user: $user,
            vault: $vault,
            name: 'Dunder mifflin',
            description: null,
        ))->execute();

        $this->assertDatabaseHas('vaults', [
            'id' => $vault->id,
            'description' => null,
        ]);

        $this->assertInstanceOf(
            Vault::class,
            $vault
        );
    }
}
