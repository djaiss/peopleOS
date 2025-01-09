<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Team;
use App\Models\User;

class CreateTeam
{
    private Team $team;

    public function __construct(
        public User $user,
        public string $name,
    ) {}

    /**
     * Create a team.
     * Anyone can create a team.
     */
    public function execute(): Team
    {
        $this->createTeam();
        $this->updateUserLastActivityDate();
        $this->log();

        return $this->team;
    }

    private function createTeam(): void
    {
        $this->team = Team::create([
            'name' => $this->name,
            'account_id' => $this->user->account_id,
        ]);
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user);
    }

    private function log(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'team_creation',
            description: 'Created the team called '.$this->name,
        );
    }
}
