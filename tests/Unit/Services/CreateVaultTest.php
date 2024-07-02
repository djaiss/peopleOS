<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Models\Vault;
use App\Services\CreateVault;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateVaultTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_a_vault(): void
    {
        $this->executeService();
    }

    private function executeService(): void
    {
        $user = User::factory()->create();

        $vault = (new CreateVault(
            user: $user,
            name: 'Dunder mifflin',
            description: null,
        ))->execute();

        $this->assertDatabaseHas('vaults', [
            'id' => $vault->id,
            'name' => 'Dunder mifflin',
            'description' => null,
        ]);

        $this->assertDatabaseHas('user_vault', [
            'vault_id' => $vault->id,
            'user_id' => $user->id,
        ]);

        $this->assertInstanceOf(
            Vault::class,
            $vault
        );
    }
}
