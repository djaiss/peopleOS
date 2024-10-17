<?php

namespace Tests\Unit\Services;

use App\Models\Company;
use App\Models\Gender;
use App\Models\User;
use App\Models\Vault;
use App\Services\CreateCompany;
use App\Services\CreateGender;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateGenderTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_a_gender(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user->account);
        $vault = $this->setPermissionInVault($user, Vault::PERMISSION_MANAGE, $vault);
        $this->executeService($user);
    }

    private function executeService(User $user): void
    {
        $gender = (new CreateGender(
            user: $user,
            label: 'Male',
        ))->execute();

        $this->assertDatabaseHas('genders', [
            'id' => $gender->id,
            'account_id' => $user->account_id,
        ]);

        $this->assertInstanceOf(
            Gender::class,
            $gender
        );

        $this->assertEquals(
            'Male',
            $gender->label
        );
    }
}
