<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\JournalTemplate;
use App\Models\User;

class CreateJournalTemplate
{
    private JournalTemplate $journalTemplate;

    public function __construct(
        private readonly User $user,
        private readonly string $name,
        private readonly string $content,
    ) {}

    public function execute(): JournalTemplate
    {
        $this->create();
        $this->updateUserLastActivityDate();
        $this->logUserAction();

        return $this->journalTemplate;
    }

    private function create(): void
    {
        $this->journalTemplate = JournalTemplate::create([
            'account_id' => $this->user->account_id,
            'name' => $this->name,
            'content' => $this->content,
        ]);
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user);
    }

    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'journal_template_creation',
            description: 'Created the journal template called '.$this->name,
        );
    }
}
