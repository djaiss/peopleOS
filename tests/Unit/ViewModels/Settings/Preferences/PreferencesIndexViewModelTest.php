<?php

namespace Tests\Unit\Domains\Settings\ManageUserPreferences\Web\ViewHelpers;

use App\Http\ViewModels\Settings\Preferences\PreferencesIndexViewModel;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PreferencesIndexViewModelTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_gets_the_data_needed_for_the_view(): void
    {
        $user = User::factory()->create([
            'name_order' => '%first_name% %last_name% (%nickname%)',
        ]);

        $array = PreferencesIndexViewModel::data($user);

        $this->assertEquals(
            1,
            count($array)
        );

        $this->assertArrayHasKey('name_order', $array);
    }

    #[Test]
    public function it_gets_the_data_needed_for_name_order(): void
    {
        $user = User::factory()->create([
            'name_order' => '%first_name% %last_name% (%nickname%)',
        ]);
        $array = PreferencesIndexViewModel::nameOrder($user);
        $this->assertEquals(
            [
                'name_example' => 'James Bond (007)',
                'name_order' => '%first_name% %last_name% (%nickname%)',
            ],
            $array
        );
    }
}
