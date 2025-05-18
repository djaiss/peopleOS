<?php

declare(strict_types=1);

namespace App\Services;

use App\Cache\PersonsListCache;
use App\Enums\GiftStatus;
use App\Models\Gift;
use App\Models\Person;
use App\Models\User;

class GetGiftsListing
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

        $gifts = Gift::where('person_id', $this->person->id)
            ->where('status', $this->person->gift_tab_shown)
            ->orderBy('gifted_at', 'desc')
            ->get();

        $giftCounts = Gift::where('person_id', $this->person->id)
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->all();

        return [
            'person' => $this->person,
            'persons' => $persons,
            'gifts' => $gifts,
            'idea_gifts_count' => $giftCounts[GiftStatus::IDEA->value] ?? 0,
            'received_gifts_count' => $giftCounts[GiftStatus::RECEIVED->value] ?? 0,
            'offered_gifts_count' => $giftCounts[GiftStatus::GIVEN->value] ?? 0,
        ];
    }
}
