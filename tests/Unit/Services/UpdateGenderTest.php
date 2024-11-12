<?php

namespace Tests\Unit\Services;

use App\Models\Gender;
use App\Models\User;
use App\Services\UpdateGender;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateGenderTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_a_gender(): void
    {
        $user = User::factory()->create();
        $gender = Gender::factory()->create([
            'account_id' => $user->account_id,
            'position' => 1,
        ]);
        $this->executeService($user, $gender);
    }

    #[Test]
    public function it_fails_if_gender_doesnt_belong_to_account(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $user = User::factory()->create();
        $gender = Gender::factory()->create();
        $this->executeService($user, $gender);
    }

    private function executeService(User $user, Gender $gender): void
    {
        $gender2 = Gender::factory()->create([
            'account_id' => $user->account_id,
            'position' => 2,
        ]);
        $gender3 = Gender::factory()->create([
            'account_id' => $user->account_id,
            'position' => 3,
        ]);

        $gender = (new UpdateGender(
            user: $user,
            gender: $gender,
            label: 'Male',
            position: 2,
        ))->execute();

        $this->assertDatabaseHas('genders', [
            'id' => $gender->id,
            'account_id' => $user->account_id,
            'position' => 2,
        ]);

        $this->assertInstanceOf(
            Gender::class,
            $gender
        );

        $this->assertEquals(
            'Male',
            $gender->label
        );

        $this->assertDatabaseHas('genders', [
            'id' => $gender2->id,
            'account_id' => $user->account_id,
            'position' => 1,
        ]);

        $this->assertDatabaseHas('genders', [
            'id' => $gender3->id,
            'account_id' => $user->account_id,
            'position' => 3,
        ]);
    }
}
