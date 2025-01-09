<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Enums\Permission;
use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Team;
use App\Models\User;
use App\Services\CreateTeam;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateTeamTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_a_team(): void
    {
        Queue::fake();

        $user = User::factory()->create([
            'permission' => Permission::ADMINISTRATOR->value,
        ]);

        $team = (new CreateTeam(
            user: $user,
            name: 'Scranton Branch',
        ))->execute();

        $this->assertDatabaseHas('teams', [
            'id' => $team->id,
            'account_id' => $user->account_id,
            'name' => 'Scranton Branch',
        ]);

        $this->assertInstanceOf(
            Team::class,
            $team
        );

        Queue::assertPushed(UpdateUserLastActivityDate::class, function (UpdateUserLastActivityDate $job) use ($user): bool {
            return $job->user->id === $user->id;
        });

        Queue::assertPushed(LogUserAction::class, function (LogUserAction $job) use ($user): bool {
            return $job->action === 'team_creation' && $job->user->id === $user->id;
        });
    }

    #[Test]
    public function hr_representative_can_create_a_team(): void
    {
        Queue::fake();

        $user = User::factory()->create([
            'permission' => Permission::HR->value,
        ]);

        $team = (new CreateTeam(
            user: $user,
            name: 'Scranton Branch',
        ))->execute();

        $this->assertDatabaseHas('teams', [
            'id' => $team->id,
            'account_id' => $user->account_id,
            'name' => 'Scranton Branch',
        ]);
    }

    #[Test]
    public function regular_member_can_create_a_team(): void
    {
        $user = User::factory()->create([
            'permission' => Permission::MEMBER->value,
        ]);

        $team = (new CreateTeam(
            user: $user,
            name: 'Scranton Branch',
        ))->execute();

        $this->assertDatabaseHas('teams', [
            'id' => $team->id,
            'account_id' => $user->account_id,
            'name' => 'Scranton Branch',
        ]);
    }
}
