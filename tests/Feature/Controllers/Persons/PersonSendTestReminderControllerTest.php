<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Persons;

use App\Jobs\SendReminder;
use App\Models\Person;
use App\Models\SpecialDate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PersonSendTestReminderControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function a_user_can_send_a_test_reminder(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);
        $specialDate = SpecialDate::factory()->create([
            'person_id' => $person->id,
            'account_id' => $user->account_id,
            'name' => 'Birthday',
            'month' => 10,
            'day' => 18,
            'year' => 1967,
            'should_be_reminded' => true,
        ]);

        $response = $this->actingAs($user)
            ->post('/persons/'.$person->slug.'/reminders/'.$specialDate->id.'/test')
            ->assertRedirectToRoute('persons.reminders.index', $person->slug);

        $response->assertSessionHas('status', __('Mail sent'));

        Queue::assertPushed(SendReminder::class, function (SendReminder $job) use ($specialDate): bool {
            return $job->specialDate->id === $specialDate->id;
        });
    }

    #[Test]
    public function it_fails_if_special_date_does_not_belong_to_person(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $otherPerson = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $specialDate = SpecialDate::factory()->create([
            'person_id' => $otherPerson->id,
            'account_id' => $user->account_id,
        ]);

        $this->actingAs($user)
            ->post('/persons/'.$person->slug.'/reminders/'.$specialDate->id.'/test')
            ->assertNotFound();
    }

    #[Test]
    public function it_fails_if_special_date_does_not_exist(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $this->actingAs($user)
            ->post('/persons/'.$person->slug.'/reminders/999/test')
            ->assertNotFound();
    }
}
