<?php

declare(strict_types=1);

namespace App\Services;

use App\Cache\PersonsListCache;
use App\Models\Note;
use App\Models\Person;
use App\Models\User;

class GetNotesListing
{
    public function __construct(
        private readonly User $user,
        private readonly Person $person,
    ) {}

    public function execute(): array
    {
        $persons = PersonsListCache::make(
            accountId: $this->user->account_id,
        )->value();

        $notes = Note::where('person_id', $this->person->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn(Note $note): array => [
                'id' => $note->id,
                'content' => $note->content,
                'created_at' => $note->created_at->format('M j, Y'),
                'is_new' => false,
            ]);

        return [
            'person' => $this->person,
            'persons' => $persons,
            'notes' => $notes,
        ];
    }
}
