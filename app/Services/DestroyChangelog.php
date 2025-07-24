<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Changelog;

/**
 * Destroy a changelog entry.
 */
class DestroyChangelog
{
    public function __construct(
        public int $id,
    ) {}

    public function execute(): void
    {
        $changelog = Changelog::findOrFail($this->id);
        $changelog->delete();
    }
}
