<?php

namespace Tests\Unit\Services;

use App\Models\MaritalStatus;
use App\Models\User;
use App\Services\CreateMaritalStatus;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateMaritalStatusTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_a_marital_status(): void
    {
        $user = User::factory()->create();
        $label = 'Asian';

        $maritalStatus = (new CreateMaritalStatus(
            user: $user,
            label: $label,
        ))->execute();

        $this->assertDatabaseHas('marital_statuses', [
            'id' => $maritalStatus->id,
            'account_id' => $user->account_id,
        ]);

        $this->assertInstanceOf(
            MaritalStatus::class,
            $maritalStatus
        );
    }
}
