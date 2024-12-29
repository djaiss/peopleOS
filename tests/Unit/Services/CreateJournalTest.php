<?php

namespace Tests\Unit\Services;

use App\Models\Journal;
use App\Models\User;
use App\Models\Vault;
use App\Services\CreateJournal;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateJournalTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_a_journal(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $this->executeService($user, $vault);
    }

    #[Test]
    public function it_fails_if_vault_doesnt_belong_to_account(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $vault = Vault::factory()->create();
        $user = User::factory()->create();
        $this->executeService($user, $vault);
    }

    private function executeService(User $user, Vault $vault): void
    {
        $journal = (new CreateJournal(
            user: $user,
            vault: $vault,
            name: 'Daily journal',
        ))->execute();

        $this->assertDatabaseHas('journals', [
            'id' => $journal->id,
            'vault_id' => $vault->id,
        ]);

        $this->assertInstanceOf(
            Journal::class,
            $journal
        );
    }
}
