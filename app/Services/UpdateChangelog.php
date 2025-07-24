<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Changelog;
use Carbon\Carbon;

/**
 * Update a changelog entry.
 */
class UpdateChangelog
{
    private Changelog $changelog;

    public function __construct(
        private readonly int $id,
        private readonly ?string $pullRequestUrl = null,
        private readonly ?string $title = null,
        private readonly ?string $description = null,
        private readonly ?string $slug = null,
        private readonly ?string $publishedAt = null,
    ) {}

    public function execute(): Changelog
    {
        $this->find();
        $this->update();
        return $this->changelog;
    }

    private function find(): void
    {
        $this->changelog = Changelog::findOrFail($this->id);
    }

    private function update(): void
    {
        $this->changelog->update([
            'pull_request_url' => $this->pullRequestUrl,
            'title' => $this->title,
            'description' => $this->description,
            'slug' => $this->slug,
            'published_at' => $this->publishedAt !== null && $this->publishedAt !== '' && $this->publishedAt !== '0' ? Carbon::parse($this->publishedAt) : null,
        ]);
    }
}
