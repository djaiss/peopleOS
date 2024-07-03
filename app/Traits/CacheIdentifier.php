<?php

namespace App\Traits;

trait CacheIdentifier
{
    protected int|string|null $identifier = null;

    public function getKey(): string
    {
        return sprintf($this->key, $this->identifier);
    }
}
