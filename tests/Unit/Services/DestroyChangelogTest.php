<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\Changelog;
use App\Services\DestroyChangelog;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Carbon\Carbon;

class DestroyChangelogTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_deletes_a_changelog(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-07-24 10:00:00'));

        $changelog = Changelog::factory()->create([
            'pull_request_url' => 'https://github.com/example/repo/pull/123',
            'title' => 'To delete',
            'description' => 'To delete',
            'slug' => 'to-delete',
            'published_at' => Carbon::now(),
        ]);

        $service = new DestroyChangelog(id: $changelog->id);
        $service->execute();

        $this->assertDatabaseMissing('changelogs', [
            'id' => $changelog->id,
        ]);
    }

    #[Test]
    public function it_throws_if_changelog_not_found(): void
    {
        $this->expectException(ModelNotFoundException::class);
        (new DestroyChangelog(id: 9999))->execute();
    }
}
