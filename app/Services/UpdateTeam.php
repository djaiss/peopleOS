<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\UserNotPartOfTheTeamException;
use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Team;
use App\Models\User;

class UpdateTeam
{
    public function __construct(
        public User $user,
        public Team $team,
        public string $name,
    ) {}

    /**
     * Update a team.
     * Anyone can update a team, as long as they are part of the team.
     */
    public function execute(): Team
    {
        $this->validate();
        $this->update();
        $this->updateUserLastActivityDate();
        $this->log();

        return $this->team;
    }

    private function validate(): void
    {
        if (! $this->user->teams()->where('id', $this->team->id)->exists()) {
            throw new UserNotPartOfTheTeamException();
        }
    }

    private function update(): void
    {
        $this->team->update([
            'name' => $this->name,
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
            action: 'team_update',
            description: 'Updated the team called '.$this->name,
        );
    }
}
