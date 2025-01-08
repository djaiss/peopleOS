<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Enums\Permission;
use App\Exceptions\PermissionException;
use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Office;
use App\Models\User;
use App\Services\CreateOffice;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateOfficeTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_an_office(): void
    {
        Queue::fake();

        $user = User::factory()->create([
            'permission' => Permission::ADMINISTRATOR->value,
        ]);

        $office = (new CreateOffice(
            user: $user,
            name: 'Scranton Branch',
        ))->execute();

        $this->assertDatabaseHas('offices', [
            'id' => $office->id,
            'account_id' => $user->account_id,
            'name' => 'Scranton Branch',
        ]);

        $this->assertInstanceOf(
            Office::class,
            $office
        );

        Queue::assertPushed(UpdateUserLastActivityDate::class, function (UpdateUserLastActivityDate $job) use ($user): bool {
            return $job->user->id === $user->id;
        });

        Queue::assertPushed(LogUserAction::class, function (LogUserAction $job) use ($user): bool {
            return $job->action === 'office_creation' && $job->user->id === $user->id;
        });
    }

    #[Test]
    public function hr_representative_cannot_create_an_office(): void
    {
        Queue::fake();

        $user = User::factory()->create([
            'permission' => Permission::HR->value,
        ]);

        $this->expectException(PermissionException::class);

        (new CreateOffice(
            user: $user,
            name: 'Scranton Branch',
        ))->execute();
    }

    #[Test]
    public function regular_member_cannot_create_an_office(): void
    {
        $user = User::factory()->create([
            'permission' => Permission::MEMBER->value,
        ]);

        $this->expectException(PermissionException::class);

        (new CreateOffice(
            user: $user,
            name: 'Scranton Branch',
        ))->execute();
    }
}
