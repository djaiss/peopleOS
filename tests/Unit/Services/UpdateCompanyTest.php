<?php

namespace Tests\Unit\Services;

use App\Models\Company;
use App\Models\User;
use App\Models\Vault;
use App\Services\UpdateCompany;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateCompanyTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_a_company(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
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
        $company = (new UpdateCompany(
            user: $user,
            company: $company,
            name: 'Dunder Mifflin 2',
        ))->execute();

        $this->assertInstanceOf(
            Company::class,
            $company
        );

        $this->assertEquals(
            'Dunder Mifflin 2',
            $company->name
        );
    }
}
