<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Api;

use App\Models\Entry;
use App\Models\Journal;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class EntryControllerTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_shows_an_entry_that_doesnt_exist_yet(): void
    {
        $user = User::factory()->create();
        $journal = Journal::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->getJson('/api/journals/' . $journal->id . '/2024/1/1');

        $entry = Entry::where('journal_id', $journal->id)
            ->first();

        $response->assertStatus(201)
            ->assertJsonPath('data.id', $entry->id)
            ->assertJsonPath('data.day', 1)
            ->assertJsonPath('data.month', 1)
            ->assertJsonPath('data.year', 2024);
    }

    #[Test]
    public function it_shows_an_entry_that_already_exists(): void
    {
        $user = User::factory()->create();
        $journal = Journal::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $entry = Entry::factory()->create([
            'journal_id' => $journal->id,
            'day' => 1,
            'month' => 1,
            'year' => 2024,
        ]);

        $response = $this->actingAs($user)
            ->getJson('/api/journals/' . $journal->id . '/2024/1/1');

        $response->assertStatus(200)
            ->assertJsonPath('data.id', $entry->id)
            ->assertJsonPath('data.day', 1)
            ->assertJsonPath('data.month', 1)
            ->assertJsonPath('data.year', 2024);
    }
}
