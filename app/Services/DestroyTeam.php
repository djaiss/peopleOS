<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\UserNotPartOfTheTeamException;
use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Team;
use App\Models\User;

class DestroyTeam
{
    public function __construct(
        public User $user,
        public Team $team,
    ) {}

    /**
     * Delete a team.
     * Anyone can delete a team, as long as they are part of the team.
     */
    public function execute(): void
    {
        $this->validate();
        $this->delete();
        $this->updateUserLastActivityDate();
        $this->log();
    }

    private function validate(): void
    {
        if (! $this->user->teams()->where('id', $this->team->id)->exists()) {
            throw new UserNotPartOfTheTeamException();
        }
    }

    private function delete(): void
    {
        $this->team->delete();
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user);
    }

    private function log(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'team_delete',
            description: 'Deleted the team called '.$this->team->name,
        );
    }
}
