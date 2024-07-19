<?php

namespace Tests\Unit\Services;

use App\Models\Company;
use App\Models\User;
use App\Models\Vault;
use App\Services\CreateCompany;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateCompanyTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_a_company(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user->account);
        $vault = $this->setPermissionInVault($user, Vault::PERMISSION_MANAGE, $vault);
        $this->executeService($user, $vault);
    }

    #[Test]
    public function it_fails_if_vault_doesnt_belong_to_account(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $vault = Vault::factory()->create();
        $user = User::factory()->create();
        $this->executeService($user, $vault);
    }

    #[Test]
    public function it_fails_if_user_doesnt_have_right_permission_in_vault(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $user = User::factory()->create();
        $vault = $this->createVault($user->account);
        $vault = $this->setPermissionInVault($user, Vault::PERMISSION_VIEW, $vault);
        $this->executeService($user, $vault);
    }

    private function executeService(User $user, Vault $vault): void
    {
        $company = (new CreateCompany(
            user: $user,
            vault: $vault,
            name: 'Dunder Mifflin',
        ))->execute();

        $this->assertDatabaseHas('companies', [
            'id' => $company->id,
            'vault_id' => $vault->id,
        ]);

        $this->assertInstanceOf(
            Company::class,
            $company
        );

        $this->assertEquals(
            'Dunder Mifflin',
            $company->name
        );
    }
}
