<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Journal;

use App\Enums\MoodType;
use App\Models\Entry;
use App\Models\Journal;
use App\Models\Mood;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class EntryMoodControllerTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_displays_the_new_mood_form(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-01-17 10:00:00'));

        $user = User::factory()->create([
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);
        Journal::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->get('/journal/2025/1/17/mood/new');

        $response->assertOk();
        $response->assertViewIs('journal.entry.partials.mood.new');
        $response->assertViewHas('day', 17);
        $response->assertViewHas('month', 1);
        $response->assertViewHas('year', 2025);
    }

    #[Test]
    public function it_creates_a_new_mood_entry(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-01-17 10:00:00'));

        $user = User::factory()->create();
        $journal = Journal::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->json('POST', '/journal/2025/1/17/mood', [
                'mood' => 'very_pleasant',
            ]);

        $response->assertRedirectToRoute('journal.entry.show', [
            'year' => 2025,
            'month' => 1,
            'day' => 17,
        ]);

        $response->assertSessionHas('status', trans('Mood logged'));

        $entry = Entry::where('journal_id', $journal->id)
            ->where('year', 2025)
            ->where('month', 1)
            ->where('day', 17)
            ->first();

        $this->assertNotNull($entry);

        $mood = Mood::where('entry_id', $entry->id)->first();
        $this->assertNotNull($mood);

        $this->assertEquals(
            MoodType::VERY_PLEASANT->getDetails(),
            $mood->mood
        );
    }
}
