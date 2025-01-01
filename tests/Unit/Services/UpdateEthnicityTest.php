<?php

namespace Tests\Unit\Services;

use App\Models\Ethnicity;
use App\Models\User;
use App\Services\UpdateEthnicity;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateEthnicityTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_an_ethnicity(): void
    {
        $user = User::factory()->create();
        $ethnicity = Ethnicity::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $label = 'New ethnicity label';

        $updatedEthnicity = (new UpdateEthnicity(
            user: $user,
            ethnicity: $ethnicity,
            label: $label,
        ))->execute();

        $this->assertDatabaseHas('ethnicities', [
            'id' => $ethnicity->id,
            'account_id' => $user->account_id,
        ]);

        $this->assertInstanceOf(
            Ethnicity::class,
            $updatedEthnicity
        );
    }

    #[Test]
    public function it_fails_if_ethnicity_doesnt_belong_to_users_account(): void
    {
        $user = User::factory()->create();
        $ethnicity = Ethnicity::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        (new UpdateEthnicity(
            user: $user,
            ethnicity: $ethnicity,
            label: 'New ethnicity label',
        ))->execute();
    }
}
