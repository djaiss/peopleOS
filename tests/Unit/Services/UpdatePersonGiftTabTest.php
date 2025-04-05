<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Enums\GiftStatus;
use App\Models\Person;
use App\Models\User;
use App\Services\UpdatePersonGiftTab;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdatePersonGiftTabTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_the_gift_tab_shown(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        (new UpdatePersonGiftTab(
            user: $user,
            person: $person,
            status: GiftStatus::GIVEN->value,
        ))->execute();

        $this->assertDatabaseHas('persons', [
            'id' => $person->id,
            'account_id' => $user->account_id,
            'gift_tab_shown' => GiftStatus::GIVEN->value,
        ]);
    }
}
