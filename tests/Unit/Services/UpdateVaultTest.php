<?php

namespace Tests\Unit\Services;

use App\Jobs\ClearCacheOfAllVaultsInAccount;
use App\Models\User;
use App\Models\Vault;
use App\Services\UpdateVault;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateVaultTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_a_vault(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user->account);
        $vault = $this->setPermissionInVault($user, Vault::PERMISSION_MANAGE, $vault);

        $this->executeService($user, $vault);
    }

    #[Test]
    public function it_fails_if_vault_doesnt_belong_to_account(): void
    {
        $user = User::factory()->create();
        $vault = Vault::factory()->create();
        $vault = $this->setPermissionInVault($user, Vault::PERMISSION_MANAGE, $vault);

        $this->expectException(ModelNotFoundException::class);
        $this->executeService($user, $vault);
    }

    private function executeService(User $user, Vault $vault): void
    {
        Queue::fake();

        $vault = (new UpdateVault(
            user: $user,
            vault: $vault,
            name: 'Dunder mifflin',
            description: null,
        ))->execute();

        $this->assertDatabaseHas('vaults', [
            'id' => $vault->id,
            'name' => 'Dunder mifflin',
            'description' => null,
        ]);

        $this->assertInstanceOf(
            Vault::class,
            $vault
        );

        Queue::assertPushed(ClearCacheOfAllVaultsInAccount::class, function ($job) use ($user) {
            return $job->account->is($user->account);
        });
    }
}
