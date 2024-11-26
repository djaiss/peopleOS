<?php

namespace Tests\Unit\ViewModels\Settings\Personalization;

use App\Http\ViewModels\Settings\Personalization\MaritalStatusViewModel;
use App\Models\Gender;
use App\Models\MaritalStatus;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MaritalStatusViewModelTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_gets_all_the_marital_statuses(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $maritalStatus = MaritalStatus::factory()->create([
            'label' => 'Single',
        ]);

        $collection = MaritalStatusViewModel::index($maritalStatus->account);

        $this->assertEquals(1, $collection->count());

        $this->assertEquals(
            [
                'id' => $maritalStatus->id,
                'label' => 'Single',
            ],
            $collection->toArray()[0]
        );
    }

    #[Test]
    public function it_gets_a_single_marital_status(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $maritalStatus = MaritalStatus::factory()->create([
            'label' => 'Single',
        ]);

        $array = MaritalStatusViewModel::maritalStatus($maritalStatus);

        $this->assertEquals(2, count($array));

        $this->assertEquals(
            [
                'id' => $maritalStatus->id,
                'label' => 'Single',
            ],
            $array
        );
    }
}
