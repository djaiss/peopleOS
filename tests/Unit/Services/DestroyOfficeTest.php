<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Office;
use App\Models\User;
use App\Services\DestroyOffice;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DestroyOfficeTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_destroys_an_office(): void
    {
        Queue::fake();

        $user = User::factory()->create();

        $office = Office::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Scranton Branch',
        ]);

        (new DestroyOffice(
            user: $user,
            office: $office,
        ))->execute();

        $this->assertDatabaseMissing('offices', [
            'id' => $office->id,
        ]);

        Queue::assertPushed(UpdateUserLastActivityDate::class, function (UpdateUserLastActivityDate $job) use ($user): bool {
            return $job->user->id === $user->id;
        });

        Queue::assertPushed(LogUserAction::class, function (LogUserAction $job) use ($user): bool {
            return $job->action === 'office_deletion'
                && $job->user->id === $user->id
                && $job->description === 'Deleted the office called Scranton Branch';
        });
    }

    #[Test]
    public function it_cant_destroy_an_office_that_is_not_in_the_user_s_account(): void
    {
        $user = User::factory()->create();

        $office = Office::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        (new DestroyOffice(
            user: $user,
            office: $office,
        ))->execute();
    }
}
