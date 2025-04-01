<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\Note;
use App\Models\Person;
use App\Models\User;
use App\Services\GetNotesListing;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GetNotesListingTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_returns_the_data_for_the_notes_listing_page(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-04-01'));
        $user = User::factory()->create();

        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $note = Note::factory()->create([
            'person_id' => $person->id,
            'content' => 'Joey does not share food!',
        ]);

        $array = (new GetNotesListing(
            user: $user,
            person: $person,
        ))->execute();

        $this->assertArrayHasKeys($array, [
            'person',
            'persons',
            'notes',
        ]);

        $this->assertEquals(1, count($array['notes']));
        $this->assertEquals(
            [
                'id' => $note->id,
                'content' => 'Joey does not share food!',
                'created_at' => 'Apr 1, 2025',
                'is_new' => false,
            ],
            $array['notes'][0],
        );
    }
}
