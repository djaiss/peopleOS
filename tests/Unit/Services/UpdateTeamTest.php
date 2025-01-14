<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Team;
use App\Models\User;
use App\Services\UpdateTeam;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateTeamTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_a_team(): void
    {
        Queue::fake();

        $user = User::factory()->create();

        $team = Team::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $user->teams()->attach($team);

        $team = (new UpdateTeam(
            user: $user,
            team: $team,
            name: 'Webmasters',
        ))->execute();

        $this->assertDatabaseHas('teams', [
            'id' => $team->id,
            'account_id' => $user->account_id,
            'name' => 'Webmasters',
        ]);

        $this->assertInstanceOf(
            Team::class,
            $team
        );

        Queue::assertPushed(UpdateUserLastActivityDate::class, function (UpdateUserLastActivityDate $job) use ($user): bool {
            return $job->user->id === $user->id;
        });

        Queue::assertPushed(LogUserAction::class, function (LogUserAction $job) use ($user): bool {
            return $job->action === 'team_update' && $job->user->id === $user->id;
        });
    }
}
