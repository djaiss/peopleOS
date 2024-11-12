<?php

namespace Tests\Unit\ViewModels\Settings\Personalization;

use App\Http\ViewModels\Settings\Personalization\GenderViewModel;
use App\Models\Contact;
use App\Models\Gender;
use App\Models\Note;
use App\Models\User;
use App\Models\Vault;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GenderViewModelTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_gets_all_the_genders(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $gender = Gender::factory()->create([
            'label' => 'Male',
            'position' => 1,
        ]);

        $collection = GenderViewModel::index($gender->account);

        $this->assertEquals(1, $collection->count());

        $this->assertEquals(
            [
                'id' => $gender->id,
                'label' => 'Male',
                'position' => 1,
            ],
            $collection->toArray()[0]
        );
    }

    #[Test]
    public function it_gets_a_single_gender(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $gender = Gender::factory()->create([
            'label' => 'Male',
            'position' => 1,
        ]);

        $array = GenderViewModel::gender($gender);

        $this->assertEquals(3, count($array));

        $this->assertEquals(
            [
                'id' => $gender->id,
                'label' => 'Male',
                'position' => 1,
            ],
            $array
        );
    }
}
