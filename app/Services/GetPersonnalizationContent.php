<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Gender;
use App\Models\JournalTemplate;
use App\Models\TaskCategory;
use App\Models\User;

class GetPersonnalizationContent
{
    public function __construct(
        private readonly User $user,
    ) {}

    public function execute(): array
    {
        $genders = Gender::where('account_id', $this->user->account_id)
            ->orderBy('position')
            ->get()
            ->map(fn(Gender $gender): array => [
                'id' => $gender->id,
                'name' => $gender->name,
            ]);

        $taskCategories = TaskCategory::where('account_id', $this->user->account_id)
            ->get()
            ->map(fn(TaskCategory $taskCategory): array => [
                'id' => $taskCategory->id,
                'name' => $taskCategory->name,
                'color' => $taskCategory->color,
            ]);

        $journalTemplates = JournalTemplate::where('account_id', $this->user->account_id)
            ->get()
            ->map(fn(JournalTemplate $journalTemplate): array => [
                'id' => $journalTemplate->id,
                'name' => $journalTemplate->name,
                'columns' => $journalTemplate->getDetails()['columns'],
                'questions' => $journalTemplate->getDetails()['questions'],
            ]);

        return [
            'genders' => $genders,
            'taskCategories' => $taskCategories,
            'journalTemplates' => $journalTemplates,
        ];
    }
}
