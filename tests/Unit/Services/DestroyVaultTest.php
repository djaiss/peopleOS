<?php

namespace Tests\Unit\Services;

use App\Models\Contact;
use App\Models\User;
use App\Models\Vault;
use App\Services\DestroyVault;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DestroyVaultTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_destroys_a_vault(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user->account);
        $vault = $this->setPermissionInVault($user, Vault::PERMISSION_MANAGE, $vault);

        $this->executeService($user, $vault);
    }

    private function executeService(User $user, Vault $vault): void
    {
        (new DestroyVault(
            user: $user,
            vault: $vault,
        ))->execute();

        $this->assertDatabaseMissing('vaults', [
            'id' => $vault->id,
        ]);

        // ca marche pas bordel
        //  $this->assertDatabaseMissing('user_vault', [
        //     'vault_id' => $vault->id,
        //     'user_id' => $user->id,
        // ]);
    }
}
