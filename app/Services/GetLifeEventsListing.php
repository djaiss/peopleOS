<?php

declare(strict_types=1);

namespace App\Services;

use App\Cache\PeopleListCache;
use App\Models\LifeEvent;
use App\Models\Person;
use App\Models\User;

class GetLifeEventsListing
{
    public function __construct(
        private readonly User $user,
        private readonly Person $person,
    ) {}

    public function execute(): array
    {
        $persons = PeopleListCache::make(
            accountId: $this->user->account_id,
        )->value();

        $lifeEvents = LifeEvent::where('person_id', $this->person->id)
            ->with('specialDate')
            ->orderBy('happened_at', 'desc')
            ->orderBy('id', 'desc')
            ->get()
            ->map(fn (LifeEvent $lifeEvent): array => [
                'id' => $lifeEvent->id,
                'description' => $lifeEvent->description,
                'happened_at' => $lifeEvent->happened_at->format('M d, Y'),
                'happened_at_ago' => $lifeEvent->happened_at->diffForHumans(),
                'comment' => $lifeEvent->comment,
                'icon' => $lifeEvent->icon,
                'bg_color' => $lifeEvent->bg_color,
                'text_color' => $lifeEvent->text_color,
                'has_reminder' => $lifeEvent->specialDate?->should_be_reminded,
            ]);

        return [
            'persons' => $persons,
            'person' => $this->person,
            'life_events' => $lifeEvents,
        ];
    }
}
