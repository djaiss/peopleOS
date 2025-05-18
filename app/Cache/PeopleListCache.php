<?php

declare(strict_types=1);

namespace App\Cache;

use App\Helpers\CacheHelper;
use App\Models\Account;
use App\Models\Person;
use App\Traits\CacheIdentifier;
use Illuminate\Support\Collection;

/**
 * All the people for the given account.
 */
final class PeopleListCache extends CacheHelper
{
    use CacheIdentifier;

    protected string $key = 'account.people-list:%s';

    protected int $ttl = 604800; // 1 week

    public function __construct(
        int $accountId,
    ) {
        $this->identifier = $accountId;
    }

    public static function make(int $accountId): static
    {
        return new self($accountId);
    }

    protected function generate(): Collection
    {
        return Person::where('account_id', $this->identifier)
            ->where('is_listed', true)
            ->select(
                'id',
                'first_name',
                'last_name',
                'maiden_name',
                'nickname',
                'slug',
                'profile_photo_path',
                'color',
            )
            ->get()
            ->map(fn(Person $person): array => [
                'id' => $person->id,
                'name' => $person->name,
                'maiden_name' => $person->maiden_name,
                'nickname' => $person->nickname,
                'slug' => $person->slug,
                'avatar' => [
                    '40' => $person->getAvatar(40),
                    '80' => $person->getAvatar(80),
                ],
            ])
            ->sortBy('name');
    }
}
