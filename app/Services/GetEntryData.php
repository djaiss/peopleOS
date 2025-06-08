<?php

declare(strict_types=1);

namespace App\Services;

use App\Helpers\JournalHelper;
use App\Models\Entry;
use App\Models\Journal;
use App\Models\Mood;
use App\Models\User;
use Illuminate\Support\Collection;

class GetEntryData
{
    private array $options = [
        'mood' => false,
    ];

    public function __construct(
        private readonly User $user,
        private readonly Entry $entry,
    ) {}

    public function execute(): array
    {
        $content = $this->getAllContent();

        return [
            'options' => $this->options,
            'entry' => $this->entry,
            'days' => $this->getDays(),
            'months' => $this->getMonths(),
            'content' => $content,
        ];
    }

    private function getAllContent(): array
    {
        return $this->getMood();
    }

    public function getDays(): Collection
    {
        return JournalHelper::getDaysInMonth(
            givenYear: $this->entry->year,
            givenMonth: $this->entry->month,
            givenDay: $this->entry->day,
        );
    }

    public function getMonths(): Collection
    {
        return JournalHelper::getMonths(
            year: $this->entry->year,
            selectedMonth: $this->entry->month,
        );
    }

    public function getMood(): array
    {
        $entryMood = $this->entry->mood;

        if ($entryMood) {
            $this->options['mood'] = true;
        }

        return $entryMood ? [
            'type' => 'mood',
            'data' => [
                'id' => $entryMood->id,
                'mood' => $entryMood->mood,
                'comment' => $entryMood->comment,
            ],
            'created_at' => $entryMood->created_at,
        ] : [];
    }
}
