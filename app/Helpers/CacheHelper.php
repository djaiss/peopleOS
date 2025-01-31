<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

abstract class CacheHelper
{
    protected string $key;

    protected int $ttl = 60;

    public function getKey(): string
    {
        return $this->key;
    }

    final public function value(): mixed
    {
        return Cache::remember(
            $this->getKey(),
            $this->ttl,
            fn (): mixed => $this->generate()
        );
    }

    final public function forget(): bool
    {
        return Cache::forget($this->getKey());
    }

    final public function refresh(): mixed
    {
        $this->forget();

        return $this->value();
    }

    abstract protected function generate(): mixed;
}
