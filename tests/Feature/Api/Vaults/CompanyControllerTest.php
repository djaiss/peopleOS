<?php

namespace Tests\Feature\Api\Vaults;

use App\Models\Company;
use App\Models\Contact;
use App\Models\User;
use App\Models\Vault;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CompanyControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_creates_a_company(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user->account);
        $vault = $this->setPermissionInVault($user, Vault::PERMISSION_MANAGE, $vault);

        Sanctum::actingAs($user);

        $response = $this->json('POST', '/api/vaults/' . $vault->id . '/companies', [
            'name' => 'Dunder Mifflin',
        ]);

        $response->assertStatus(201);
        $company = Company::orderBy('id', 'desc')->first();

        $this->assertEquals(
            [
                'id' => $company->id,
                'object' => 'company',
                'name' => 'Dunder Mifflin',
            ],
            $response->json()
        );
    }

    #[Test]
    public function it_updates_a_company(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user->account);
        $vault = $this->setPermissionInVault($user, Vault::PERMISSION_MANAGE, $vault);
        $company = Company::factory()->create([
            'vault_id' => $vault->id,
            'name' => 'Park & Sons',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/vaults/' . $vault->id . '/companies/' . $company->id, [
            'name' => 'Dunder Mifflin',
        ]);

        $response->assertStatus(200);

        $this->assertEquals(
            [
                'id' => $company->id,
                'object' => 'company',
                'name' => 'Dunder Mifflin',
            ],
            $response->json()
        );
    }

    #[Test]
    public function it_deletes_a_company(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user->account);
        $vault = $this->setPermissionInVault($user, Vault::PERMISSION_MANAGE, $vault);
        $company = Company::factory()->create([
            'vault_id' => $vault->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/vaults/' . $vault->id . '/companies/' . $company->id);

        $response->assertStatus(200);

        $this->assertEquals(
            [
                'status' => 'success',
            ],
            $response->json()
        );
    }

    #[Test]
    public function it_cant_delete_a_company(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user->account);
        $vault = $this->setPermissionInVault($user, Vault::PERMISSION_MANAGE, $vault);
        $company = Company::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/vaults/' . $vault->id . '/companies/' . $company->id);

        $response->assertStatus(401);
    }

    #[Test]
    public function it_lists_all_the_companies(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user->account);
        $vault = $this->setPermissionInVault($user, Vault::PERMISSION_MANAGE, $vault);
        Company::factory()->create([
            'vault_id' => $vault->id,
            'name' => 'Dunder Mifflin',
        ]);
        Company::factory()->create([
            'vault_id' => $vault->id,
            'name' => 'Parks & Sons',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/vaults/' . $vault->id . '/companies');

        $response->assertStatus(200);

        $this->assertEquals(
            2,
            count($response->json())
        );
    }
}
