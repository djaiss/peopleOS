<?php

namespace Tests\Unit\Services;

use App\Models\Company;
use App\Models\User;
use App\Models\Vault;
use App\Services\DestroyCompany;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DestroyCompanyTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_destroys_a_company(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user->account);
        $vault = $this->setPermissionInVault($user, Vault::PERMISSION_MANAGE, $vault);
        $company = Company::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $this->executeService($user, $company);
    }

    #[Test]
    public function it_fails_if_vault_doesnt_belong_to_account(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $vault = Vault::factory()->create();
        $user = User::factory()->create();
        $company = Company::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $this->executeService($user, $company);
    }

    #[Test]
    public function it_fails_if_user_doesnt_have_right_permission_in_vault(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $user = User::factory()->create();
        $vault = $this->createVault($user->account);
        $vault = $this->setPermissionInVault($user, Vault::PERMISSION_VIEW, $vault);
        $company = Company::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $this->executeService($user, $company);
    }

    #[Test]
    public function it_fails_if_company_doesnt_belong_to_vault(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $vault = Vault::factory()->create();
        $user = User::factory()->create();
        $company = Company::factory()->create();
        $this->executeService($user, $company);
    }

    private function executeService(User $user, Company $company): void
    {
        (new DestroyCompany(
            user: $user,
            company: $company,
        ))->execute();

        $this->assertDatabaseMissing('companies', [
            'id' => $company->id,
        ]);
    }
}
