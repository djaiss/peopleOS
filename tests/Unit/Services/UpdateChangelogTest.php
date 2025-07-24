<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\Changelog;
use App\Services\UpdateChangelog;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Carbon\Carbon;

class UpdateChangelogTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_a_changelog(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-07-24 10:00:00'));

        $changelog = Changelog::factory()->create([
            'pull_request_url' => 'https://github.com/example/repo/pull/123',
            'title' => 'Old title',
            'description' => 'Old description',
            'slug' => 'old-title',
            'published_at' => Carbon::now(),
        ]);

        $service = new UpdateChangelog(
            id: $changelog->id,
            title: 'New title',
            description: 'New description',
            slug: 'new-title',
            pullRequestUrl: 'https://github.com/example/repo/pull/123',
            publishedAt: '2025-07-24 10:00:00',
        );

        $updated = $service->execute();

        $this->assertEquals(
            'New title',
            $updated->fresh()->title,
        );
        $this->assertEquals(
            'New description',
            $updated->fresh()->description,
        );
        $this->assertEquals(
            'new-title',
            $updated->fresh()->slug,
        );
        $this->assertEquals(
            'https://github.com/example/repo/pull/123',
            $updated->fresh()->pull_request_url,
        );
        $this->assertEquals(
            '2025-07-24 10:00:00',
            $updated->fresh()->published_at->toDateTimeString(),
        );
    }

    #[Test]
    public function it_throws_if_changelog_not_found(): void
    {
        $this->expectException(ModelNotFoundException::class);
        (new UpdateChangelog(id: 9999, title: 'x'))->execute();
    }
}
