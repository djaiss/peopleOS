<?php

namespace Tests\Unit\Helpers;

use App\Helpers\NameHelper;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class NameHelperTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_gets_the_name_according_to_the_user_preference(): void
    {
        $user = User::factory()->create([
            'name_order' => '%first_name%',
        ]);
        $contact = Contact::factory()->create([
            'first_name' => 'James',
            'last_name' => 'Bond',
            'nickname' => '007',
            'middle_name' => 'W.',
            'maiden_name' => 'Muller',
        ]);

        $this->assertEquals(
            'James',
            NameHelper::formatContactName($user, $contact)
        );

        $user->update(['name_order' => '%last_name%']);
        $this->assertEquals(
            'Bond',
            NameHelper::formatContactName($user, $contact)
        );

        $user->update(['name_order' => '%first_name% %last_name%']);
        $this->assertEquals(
            'James Bond',
            NameHelper::formatContactName($user, $contact)
        );

        $user->update(['name_order' => '%first_name% (%maiden_name%) %last_name%']);
        $this->assertEquals(
            'James (Muller) Bond',
            NameHelper::formatContactName($user, $contact)
        );

        $user->update(['name_order' => '%last_name% (%maiden_name%)  || (%nickname%) || %first_name%']);
        $this->assertEquals(
            'Bond (Muller)  || (007) || James',
            NameHelper::formatContactName($user, $contact)
        );
    }
}
