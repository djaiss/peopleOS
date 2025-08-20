<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\Gender;
use App\Models\TaskCategory;
use App\Models\User;
use App\Services\GetPersonnalizationContent;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GetPersonnalizationContentTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_returns_the_content_for_the_personalization_page(): void
    {
        $user = User::factory()->create([
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);

        $gender = Gender::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Male',
        ]);

        $taskCategory = TaskCategory::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Work',
            'color' => '#000000',
        ]);

        $array = (new GetPersonnalizationContent(
            user: $user,
        ))->execute();

        $this->assertArrayHasKeys($array, ['genders', 'taskCategories']);

        $this->assertCount(1, $array['genders']);
        $this->assertEquals(
            [
                'id' => $gender->id,
                'name' => 'Male',
            ],
            $array['genders'][0],
        );

        $this->assertCount(1, $array['taskCategories']);
        $this->assertEquals(
            [
                'id' => $taskCategory->id,
                'name' => 'Work',
                'color' => '#000000',
            ],
            $array['taskCategories'][0],
        );
    }
}
