<?php

namespace Tests\Unit\Services;

use App\Jobs\ClearCacheForAllContacts;
use App\Models\Gender;
use App\Models\User;
use App\Services\UpdateGender;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
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
        Queue::fake();

        $gender = (new UpdateGender(
            user: $user,
            gender: $gender,
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

        Queue::assertPushed(
            ClearCacheForAllContacts::class
        );
    }
}
