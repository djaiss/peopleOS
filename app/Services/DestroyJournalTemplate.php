<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\JournalTemplate;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DestroyJournalTemplate
{
    public function __construct(
        private readonly User $user,
        private readonly JournalTemplate $journalTemplate,
    ) {}

    public function execute(): void
    {
        $this->validate();

        $name = $this->journalTemplate->name;

        $this->journalTemplate->delete();

        $this->updateUserLastActivityDate();
        $this->logUserAction($name);
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->journalTemplate->account_id) {
            throw new ModelNotFoundException();
        }
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user);
    }

    private function logUserAction(string $name): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'journal_template_deletion',
            description: 'Deleted the journal template called '.$name,
        );
    }
}
