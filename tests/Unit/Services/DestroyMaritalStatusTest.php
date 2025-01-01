<?php

namespace Tests\Unit\Services;

use App\Models\MaritalStatus;
use App\Models\User;
use App\Services\DestroyMaritalStatus;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DestroyMaritalStatusTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_destroys_a_marital_status(): void
    {
        $user = User::factory()->create();
        $maritalStatus = MaritalStatus::factory()->create([
            'account_id' => $user->account_id,
        ]);

        (new DestroyMaritalStatus(
            user: $user,
            maritalStatus: $maritalStatus,
        ))->execute();

        $this->assertDatabaseMissing('marital_statuses', [
            'id' => $maritalStatus->id,
        ]);
    }

    #[Test]
    public function it_fails_if_marital_status_doesnt_belong_to_users_account(): void
    {
        $user = User::factory()->create();
        $maritalStatus = MaritalStatus::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        (new DestroyMaritalStatus(
            user: $user,
            maritalStatus: $maritalStatus,
        ))->execute();
    }
}
