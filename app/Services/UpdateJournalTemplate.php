<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\JournalTemplate;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateJournalTemplate
{
    public function __construct(
        private readonly User $user,
        private readonly JournalTemplate $journalTemplate,
        private readonly string $name,
        private readonly string $content,
    ) {}

    public function execute(): JournalTemplate
    {
        $this->validate();
        $this->update();
        $this->updateUserLastActivityDate();
        $this->logUserAction();

        return $this->journalTemplate;
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->journalTemplate->account_id) {
            throw new ModelNotFoundException();
        }

        (new ValidateYamlStructure($this->content))->execute();
    }

    private function update(): void
    {
        $this->journalTemplate->update([
            'name' => $this->name,
            'content' => $this->content,
        ]);
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'journal_template_update',
            description: 'Updated the journal template called ' . $this->name,
        )->onQueue('low');
    }
}
