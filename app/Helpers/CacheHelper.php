<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

/**
 * Create or retrieve a value from the cache.
 */
abstract class CacheHelper
{
    protected string $key;

    protected int $ttl = 60;

    /**
     * Get the key for the cache.
     *
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * Get the value from the cache.
     *
     * @return mixed
     */
    final public function value(): mixed
    {
        return Cache::remember(
            $this->getKey(),
            $this->ttl,
            fn(): mixed => $this->generate(),
        );
    }

    /**
     * Forget the cache.
     *
     * @return bool
     */
    final public function forget(): bool
    {
        return Cache::forget($this->getKey());
    }

    /**
     * Refresh the cache.
     *
     * @return mixed
     */
    final public function refresh(): mixed
    {
        $this->forget();

        return $this->value();
    }

    abstract protected function generate(): mixed;
}
