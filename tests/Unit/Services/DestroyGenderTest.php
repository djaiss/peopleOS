<?php

namespace Tests\Unit\Services;

use App\Jobs\ClearCacheForAllContacts;
use App\Models\Gender;
use App\Models\User;
use App\Services\DestroyGender;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DestroyGenderTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_destroys_a_gender(): void
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

        (new DestroyGender(
            user: $user,
            gender: $gender,
        ))->execute();

        $this->assertDatabaseMissing('genders', [
            'id' => $gender->id,
        ]);

        Queue::assertPushed(
            ClearCacheForAllContacts::class
        );
    }
}
