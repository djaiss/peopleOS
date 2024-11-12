<?php

namespace Tests\Unit\ViewModels\Settings\Personalization;

use App\Http\ViewModels\Settings\Personalization\EthnicityViewModel;
use App\Models\Ethnicity;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class EthnicityViewModelTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_gets_all_the_ethnicities(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $ethnicity = Ethnicity::factory()->create([
            'label' => 'Male',
        ]);

        $collection = EthnicityViewModel::index($ethnicity->account);

        $this->assertEquals(1, $collection->count());

        $this->assertEquals(
            [
                'id' => $ethnicity->id,
                'label' => 'Male',
            ],
            $collection->toArray()[0]
        );
    }

    #[Test]
    public function it_gets_a_single_ethnicity(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $ethnicity = Ethnicity::factory()->create([
            'label' => 'Male',
        ]);

        $array = EthnicityViewModel::ethnicity($ethnicity);

        $this->assertEquals(2, count($array));

        $this->assertEquals(
            [
                'id' => $ethnicity->id,
                'label' => 'Male',
            ],
            $array
        );
    }
}
