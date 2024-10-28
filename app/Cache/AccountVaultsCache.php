<?php

namespace App\Cache;

use App\Helpers\CacheHelper;
use App\Models\Account;
use App\Models\Vault;
use App\Traits\CacheIdentifier;
use Illuminate\Support\Collection;

/**
 * All the vaults for the given account.
 */
final class AccountVaultsCache extends CacheHelper
{
    use CacheIdentifier;

    protected string $key = 'account.vaults:%s';

    protected int $ttl = 604800; // 1 week

    public function __construct(
        protected readonly Account $account,
    ) {
        $this->identifier = $account->id;
    }

    public static function make(Account $account): static
    {
        return new self($account);
    }

    protected function generate(): Collection
    {
        return $this->account->vaults()
            ->get()
            ->map(fn (Vault $vault): array => [
                'id' => $vault->id,
                'name' => $vault->name,
                'description' => $vault->description,
                'updated_at' => $vault->updated_at->diffForHumans(),
                'url' => [
                    'show' => route('vaults.show', $vault),
                ],
            ])
            ->sortBy('name');
    }
}
