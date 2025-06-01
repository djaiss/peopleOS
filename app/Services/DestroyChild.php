<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Child;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DestroyChild
{
    public function __construct(
        private readonly User $user,
        private readonly Child $child,
    ) {}

    public function execute(): Child
    {
        $this->validate();
        $this->delete();
        $this->changeKidsStatus();
        $this->updateUserLastActivityDate();
        $this->logUserAction();

        return $this->child;
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->child->account_id) {
            throw new ModelNotFoundException('Child not found in user\'s account');
        }
    }

    private function delete(): void
    {
        $this->child->delete();
    }

    private function changeKidsStatus(): void
    {
        if ($this->child->parent_id) {
            (new UpdateParentRelationshipStatus(
                person: $this->child->parent,
            ))->execute();
        }

        if ($this->child->second_parent_id) {
            (new UpdateParentRelationshipStatus(
                person: $this->child->secondParent,
            ))->execute();
        }
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function logUserAction(): void
    {
        $description = "Deleted a child for {$this->child->parent?->name}";

        if ($this->child->secondParent) {
            $description .= " and {$this->child->secondParent->name}";
        }

        LogUserAction::dispatch(
            user: $this->user,
            action: 'child_relationship_deletion',
            description: 'Deleted a child',
        )->onQueue('low');
    }
}
