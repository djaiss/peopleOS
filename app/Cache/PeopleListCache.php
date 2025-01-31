<?php

declare(strict_types=1);

namespace App\Cache;

use App\Helpers\CacheHelper;
use App\Models\Account;
use App\Models\Person;
use App\Traits\CacheIdentifier;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

/**
 * All the people for the given account.
 */
final class PeopleListCache extends CacheHelper
{
    use CacheIdentifier;

    protected string $key = 'account.people:%s';

    protected int $ttl = 604800; // 1 week

    public function __construct(
        private int $accountId,
    ) {
        $this->identifier = $accountId;
    }

    public static function make(int $accountId): static
    {
        return new self($accountId);
    }

    protected function generate(): Collection
    {
        return Person::where('account_id', Auth::user()->account_id)
            ->where('is_listed', true)
            ->get()
            ->map(fn (Person $person): array => [
                'id' => $person->id,
                'name' => $person->name,
                'maiden_name' => $person->maiden_name,
                'nickname' => $person->nickname,
                'slug' => $person->slug,
            ])
            ->sortBy('name');
    }
}
