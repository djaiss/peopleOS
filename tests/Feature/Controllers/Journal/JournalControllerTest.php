<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Journal;

use App\Models\Journal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class JournalControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_gets_the_current_day_and_shows_the_corresponding_entry(): void
    {
        Carbon::setTestNow('2023-10-01 12:00:00');
        $user = User::factory()->create();
        Journal::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $this->actingAs($user)
            ->get('/journal')
            ->assertRedirectToRoute('journal.entry.show', [
                'day' => 1,
                'month' => 10,
                'year' => 2023,
            ]);
    }
}
