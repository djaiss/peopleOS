<?php

namespace Tests\Unit\Services;

use App\Jobs\ClearCacheOfAllVaultsInAccount;
use App\Models\Contact;
use App\Models\User;
use App\Models\Vault;
use App\Services\CreateVault;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
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
        Queue::fake();
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
            'contact_id' => Contact::all()->first()->id,
            'permission' => Vault::PERMISSION_MANAGE,
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
