<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Services\CreateChangelog;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Carbon\Carbon;

class CreateChangelogTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_a_changelog(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-07-24 10:00:00'));

        $service = new CreateChangelog(
            pullRequestUrl: 'https://github.com/example/repo/pull/123',
            title: 'Add new feature',
            description: 'This adds a new feature.',
            slug: 'add-new-feature',
            publishedAt: Carbon::now()->toDateTimeString(),
        );

        $changelog = $service->execute();

        $this->assertDatabaseHas('changelogs', [
            'pull_request_url' => 'https://github.com/example/repo/pull/123',
        ]);

        $this->assertEquals(
            'Add new feature',
            $changelog->fresh()->title,
        );
        $this->assertEquals(
            'This adds a new feature.',
            $changelog->fresh()->description,
        );
        $this->assertEquals(
            'add-new-feature',
            $changelog->fresh()->slug,
        );
        $this->assertEquals(
            Carbon::now()->toDateTimeString(),
            $changelog->fresh()->published_at->toDateTimeString(),
        );
    }
}
