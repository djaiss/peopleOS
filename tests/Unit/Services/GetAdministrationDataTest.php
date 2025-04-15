<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\EmailSent;
use App\Models\Log;
use App\Models\Person;
use App\Models\User;
use App\Services\GetAdministrationData;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GetAdministrationDataTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_returns_a_subset_of_logs(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));

        $user = User::factory()->create([
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);

        Log::factory()->create([
            'account_id' => $user->account_id,
            'user_id' => $user->id,
            'action' => 'profile_update',
            'description' => 'Updated their profile',
        ]);

        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);

        EmailSent::factory()->create([
            'account_id' => $user->account_id,
            'person_id' => $person->id,
            'email_type' => 'birthday_wishes',
            'email_address' => 'ross.geller@friends.com',
            'subject' => 'Happy Birthday!',
            'body' => 'Hope you have a great day!',
        ]);

        $array = (new GetAdministrationData(
            user: $user,
        ))->execute();

        $this->assertArrayHasKeys($array, [
            'logs',
            'has_more_logs',
            'emails_sent',
            'has_more_emails_sent',
        ]);
        $this->assertArrayHasKeys(
            $array['logs'][0],
            [
                'user',
                'action',
                'description',
                'created_at',
            ]
        );
        $this->assertCount(1, $array['logs']);
        $this->assertEquals([
            'user' => [
                'name' => 'Ross Geller',
            ],
            'action' => 'profile_update',
            'description' => 'Updated their profile',
            'created_at' => '0 seconds ago',
        ], $array['logs'][0]);

        $this->assertFalse($array['has_more_logs']);

        $this->assertCount(1, $array['emails_sent']);
        $this->assertArrayHasKeys(
            $array['emails_sent'][0],
            [
                'email_type',
                'email_address',
                'subject',
                'body',
                'sent_at',
                'delivered_at',
                'bounced_at',
                'person',
            ]
        );

        $this->assertFalse($array['has_more_emails_sent']);
    }
}
