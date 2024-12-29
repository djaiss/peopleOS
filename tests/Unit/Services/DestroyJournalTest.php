<?php

namespace Tests\Unit\Services;

use App\Models\Journal;
use App\Models\User;
use App\Models\Vault;
use App\Services\DestroyJournal;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DestroyJournalTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_destroys_a_journal(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $journal = Journal::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $this->executeService($user, $journal);
    }

    #[Test]
    public function it_fails_if_vault_doesnt_belong_to_account(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $vault = Vault::factory()->create();
        $user = User::factory()->create();
        $journal = Journal::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $this->executeService($user, $journal);
    }

    #[Test]
    public function it_fails_if_journal_doesnt_belong_to_vault(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $user = User::factory()->create();
        $journal = Journal::factory()->create();
        $this->executeService($user, $journal);
    }

    private function executeService(User $user, Journal $journal): void
    {
        (new DestroyJournal(
            user: $user,
            journal: $journal,
        ))->execute();

        $this->assertDatabaseMissing('journals', [
            'id' => $journal->id,
        ]);
    }
}
