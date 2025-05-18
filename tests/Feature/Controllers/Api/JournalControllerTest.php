<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Api;

use App\Models\Journal;
use App\Models\JournalTemplate;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class JournalControllerTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_gets_a_list_of_journals(): void
    {
        $user = User::factory()->create();
        $journal = Journal::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'My Journal',
        ]);
        Journal::factory()->create();

        $response = $this->actingAs($user)
            ->getJson('/api/journals');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id', $journal->id)
            ->assertJsonPath('data.0.name', 'My Journal');
    }

    #[Test]
    public function it_creates_a_journal(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/api/journals', [
                'name' => 'New Journal',
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.name', 'New Journal');
    }

    #[Test]
    public function it_creates_a_journal_with_template(): void
    {
        $user = User::factory()->create();
        $template = JournalTemplate::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->postJson('/api/journals', [
                'name' => 'New Journal',
                'journal_template_id' => $template->id,
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.name', 'New Journal')
            ->assertJsonPath('data.journal_template_id', $template->id);
    }

    #[Test]
    public function it_shows_a_journal(): void
    {
        $user = User::factory()->create();
        $journal = Journal::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'My Journal',
        ]);

        $response = $this->actingAs($user)
            ->getJson('/api/journals/' . $journal->id);

        $response->assertStatus(200)
            ->assertJsonPath('data.id', $journal->id)
            ->assertJsonPath('data.name', 'My Journal');
    }

    #[Test]
    public function it_updates_a_journal(): void
    {
        $user = User::factory()->create();
        $journal = Journal::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Old Name',
        ]);

        $response = $this->actingAs($user)
            ->putJson('/api/journals/' . $journal->id, [
                'name' => 'Updated Name',
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.name', 'Updated Name');
    }

    #[Test]
    public function it_updates_a_journal_with_template(): void
    {
        $user = User::factory()->create();
        $journal = Journal::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Old Name',
        ]);
        $template = JournalTemplate::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->putJson('/api/journals/' . $journal->id, [
                'name' => 'Updated Name',
                'journal_template_id' => $template->id,
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.name', 'Updated Name')
            ->assertJsonPath('data.journal_template_id', $template->id);
    }

    #[Test]
    public function it_deletes_a_journal(): void
    {
        $user = User::factory()->create();
        $journal = Journal::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->deleteJson('/api/journals/' . $journal->id);

        $response->assertStatus(204);
    }

    #[Test]
    public function it_cant_access_journal_from_another_account(): void
    {
        $user = User::factory()->create();
        $journal = Journal::factory()->create();

        $response = $this->actingAs($user)
            ->getJson('/api/journals/' . $journal->id);

        $response->assertStatus(404);

        $response = $this->actingAs($user)
            ->putJson('/api/journals/' . $journal->id, [
                'name' => 'New name',
            ]);

        $response->assertStatus(404);

        $response = $this->actingAs($user)
            ->deleteJson('/api/journals/' . $journal->id);

        $response->assertStatus(404);
    }
}
