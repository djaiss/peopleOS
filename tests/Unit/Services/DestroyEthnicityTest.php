<?php

namespace Tests\Unit\Services;

use App\Jobs\ClearCacheForAllContactsInAccount;
use App\Models\Ethnicity;
use App\Models\User;
use App\Services\DestroyEthnicity;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DestroyEthnicityTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_destroys_an_ethnicity(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $ethnicity = Ethnicity::factory()->create([
            'account_id' => $user->account_id,
        ]);

        (new DestroyEthnicity(
            user: $user,
            ethnicity: $ethnicity,
        ))->execute();

        $this->assertDatabaseMissing('ethnicities', [
            'id' => $ethnicity->id,
        ]);

        Queue::assertPushed(ClearCacheForAllContactsInAccount::class, function ($job) use ($user) {
            return $job->account->id === $user->account_id;
        });
    }

    #[Test]
    public function it_fails_if_ethnicity_doesnt_belong_to_users_account(): void
    {
        $user = User::factory()->create();
        $ethnicity = Ethnicity::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        (new DestroyEthnicity(
            user: $user,
            ethnicity: $ethnicity,
        ))->execute();
    }
}
