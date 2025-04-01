<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\Gender;
use App\Models\User;
use App\Services\GetCreatePersonData;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GetCreatePersonDataTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_returns_the_data_for_the_create_person_page(): void
    {
        $user = User::factory()->create([
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);

        $gender = Gender::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Male',
        ]);

        $array = (new GetCreatePersonData(
            user: $user,
        ))->execute();

        $this->assertArrayHasKeys($array, ['genders']);

        $this->assertCount(1, $array['genders']);
        $this->assertEquals(
            [
                'id' => $gender->id,
                'name' => 'Male',
            ],
            $array['genders'][0]
        );
    }
}
