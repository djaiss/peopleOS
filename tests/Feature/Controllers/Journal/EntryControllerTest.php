<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Persons;

use App\Enums\KidsStatusType;
use App\Enums\MaritalStatusType;
use App\Models\Gender;
use App\Models\Journal;
use App\Models\Person;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class EntryControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_gets_the_current_entry(): void
    {
        Carbon::setTestNow('2023-10-01 12:00:00');
        $user = User::factory()->create();
        Journal::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->get('/journal/2023/10/1');

        $response->assertSessionHasNoErrors();
        $response->assertViewIs('journal.entry.show');
    }
}
