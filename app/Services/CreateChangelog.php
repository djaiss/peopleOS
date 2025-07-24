<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Changelog;
use Carbon\Carbon;

/**
 * Create a changelog entry.
 */
class CreateChangelog
{
    private Changelog $changelog;

    public function __construct(
        private readonly string $pullRequestUrl,
        private readonly string $title,
        private readonly string $description,
        private readonly string $slug,
        private readonly ?string $publishedAt = null,
    ) {}

    public function execute(): Changelog
    {
        $this->create();
        return $this->changelog;
    }

    private function create(): void
    {
        $this->changelog = Changelog::create([
            'pull_request_url' => $this->pullRequestUrl,
            'title' => $this->title,
            'description' => $this->description,
            'slug' => $this->slug,
            'published_at' => $this->publishedAt !== null && $this->publishedAt !== '' && $this->publishedAt !== '0' ? Carbon::parse($this->publishedAt) : null,
        ]);
    }
}
