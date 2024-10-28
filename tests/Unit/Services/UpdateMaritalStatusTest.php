<?php

namespace Tests\Unit\Services;

use App\Models\MaritalStatus;
use App\Models\User;
use App\Services\UpdateMaritalStatus;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateMaritalStatusTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_a_marital_status()
    {
        $user = User::factory()->create();
        $maritalStatus = MaritalStatus::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $label = 'New marital status label';

        $updatedMaritalStatus = (new UpdateMaritalStatus(
            user: $user,
            maritalStatus: $maritalStatus,
            label: $label,
        ))->execute();

        $this->assertDatabaseHas('marital_statuses', [
            'id' => $maritalStatus->id,
            'account_id' => $user->account_id,
        ]);

        $this->assertInstanceOf(
            MaritalStatus::class,
            $updatedMaritalStatus
        );
    }

    #[Test]
    public function it_fails_if_marital_status_doesnt_belong_to_users_account()
    {
        $user = User::factory()->create();
        $maritalStatus = MaritalStatus::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        (new UpdateMaritalStatus(
            user: $user,
            maritalStatus: $maritalStatus,
            label: 'New marital status label',
        ))->execute();
    }
}
