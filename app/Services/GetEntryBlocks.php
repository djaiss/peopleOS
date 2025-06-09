<?php

declare(strict_types=1);

namespace App\Services;

use App\Helpers\JournalHelper;
use App\Models\Entry;
use App\Models\EntryBlock;
use App\Models\Mood;
use Illuminate\Support\Collection;

class GetEntryBlocks
{
    private array $options = [
        'mood' => false,
    ];

    public function __construct(
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
