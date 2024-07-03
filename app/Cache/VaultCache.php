<?php

namespace App\Cache;

use App\Helpers\CacheHelper;
use App\Http\ViewModels\Message\MessageLayoutViewModel;
use App\Http\ViewModels\Vaults\VaultViewModel;
use App\Models\User;
use App\Traits\CacheIdentifier;
use Illuminate\Support\Collection;

final class VaultCache extends CacheHelper
{
    use CacheIdentifier;

    protected string $key = 'user.vaults:%s';
    protected int $ttl = 604800;

    public function __construct(
        protected readonly User $user,
    ) {
        $this->identifier = $user->id;
    }

    public static function make(User $user): static
    {
        return new self($user);
    }

    protected function generate(): Collection
    {
        return VaultViewModel::index($this->user);
    }
}
