<?php

declare(strict_types=1);

namespace App\Services;

use App\Cache\JournalDaysCache;
use App\Cache\JournalMonthsCache;
use App\Models\Entry;
use App\Models\EntryBlock;
use App\Models\Mood;
use App\Models\User;
use Illuminate\Support\Collection;

class GetEntryBlocks
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
        $blocks = $this->getAllBlocks();

        return [
            'options' => $this->options,
            'entry' => $this->entry,
            'days' => $this->getDays(),
            'months' => $this->getMonths(),
            'blocks' => $blocks,
        ];
    }

    private function getAllBlocks(): Collection
    {
        $blocksCollection = collect();

        foreach ($this->entry->blocks as $block) {
            if ($block->blockable_type === Mood::class) {
                $blocksCollection->push($this->getMood($block));
            }
        }

        return $blocksCollection;
    }

    public function getDays(): Collection
    {
        return JournalDaysCache::make(
            accountId: $this->user->account_id,
            year: $this->entry->year,
            month: $this->entry->month,
            day: $this->entry->day,
        )->value();
    }

    public function getMonths(): Collection
    {
        return JournalMonthsCache::make(
            accountId: $this->user->account_id,
            year: $this->entry->year,
            selectedMonth: $this->entry->month,
        )->value();
    }

    public function getMood(EntryBlock $block): array
    {
        /** @var Mood $entryMood */
        $entryMood = $block->blockable;

        $this->options['mood'] = true;

        return [
            'type' => 'mood',
            'data' => [
                'id' => $entryMood->id,
                'mood' => $entryMood->mood,
                'comment' => $entryMood->comment,
            ],
            'created_at' => $entryMood->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
