<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\Person;
use App\Models\User;
use App\Models\WorkHistory;
use App\Services\GetWorkInformationListing;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GetWorkInformationListingTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_returns_the_data_for_the_reminders_listing_page(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Chandler',
            'last_name' => 'Bing',
        ]);
        $workHistory = WorkHistory::factory()->create([
            'person_id' => $person->id,
            'job_title' => 'Statistical Analysis and Data Reconfiguration',
            'company_name' => 'WENUS Corp',
            'duration' => '2 years',
            'estimated_salary' => '$50,000',
            'active' => true,
        ]);

        $array = (new GetWorkInformationListing(
            user: $user,
            person: $person,
        ))->execute();

        $this->assertArrayHasKeys($array, [
            'person',
            'persons',
            'work_histories',
        ]);

        $workHistories = $array['work_histories'];
        $this->assertCount(1, $workHistories);
        $this->assertEquals(
            [
                'id' => $workHistory->id,
                'title' => 'Statistical Analysis and Data Reconfiguration',
                'company' => 'WENUS Corp',
                'duration' => '2 years',
                'salary' => '$50,000',
                'is_current' => true,
            ],
            $workHistories[0],
        );
    }
}
