<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Changelog;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Carbon\Carbon;

class ChangelogTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_can_create_a_changelog(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-07-24 10:00:00'));

        $changelog = Changelog::factory()->create([
            'title' => 'Add new feature',
            'description' => 'This adds a new feature.',
            'slug' => 'add-new-feature',
            'pull_request_url' => 'https://github.com/example/repo/pull/123',
            'published_at' => Carbon::now(),
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
            'https://github.com/example/repo/pull/123',
            $changelog->fresh()->pull_request_url,
        );

        $this->assertEquals(
            Carbon::now()->toDateTimeString(),
            $changelog->fresh()->published_at->toDateTimeString(),
        );
    }
}
