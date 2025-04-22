<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Entry;
use App\Models\Journal;
use App\Models\User;
use App\Services\CreateOrRetrieveEntry;
use App\Services\GetEntryData;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GetEntryDataTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_gets_the_data_needed_for_viewing_an_entry(): void
    {
        $user = User::factory()->create();
        $journal = Journal::factory()->create([
            'account_id' => $user->account_id,
        ]);
        Entry::factory()->create([
            'journal_id' => $journal->id,
            'day' => 1,
            'month' => 1,
            'year' => 2023,
        ]);

        $array = (new GetEntryData(
            user: $user,
            day: 1,
            month: 1,
            year: 2023,
        ))->execute();

        $this->assertArrayHasKeys(
            $array,
            [
                'entry', 'days', 'months'
            ]
        );

        $this->assertInstanceOf(
            Entry::class,
            $array['entry']
        );
    }
}
