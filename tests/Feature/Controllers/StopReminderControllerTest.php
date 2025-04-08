<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers;

use App\Models\Account;
use App\Models\Person;
use App\Models\SpecialDate;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;


class StopReminderControllerTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_stops_sending_reminders_and_displays_confirmation_page(): void
    {
        $account = Account::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $account->id,
        ]);
        $specialDate = SpecialDate::factory()->create([
            'account_id' => $account->id,
            'person_id' => $person->id,
            'should_be_reminded' => true,
        ]);

        $personIdHash = Crypt::encryptString((string) $person->id);
        $url = URL::signedRoute('reminder.stop', [
            'hash' => $personIdHash,
            'id' => $specialDate->id,
        ]);

        $response = $this->get($url);

        $response->assertStatus(200);
        $response->assertViewIs('persons.stop-reminder');
        $response->assertViewHas('name', $person->name);
        $response->assertViewHas('occasion', $specialDate->name);

        $this->assertFalse($specialDate->fresh()->should_be_reminded);
    }

    #[Test]
    public function it_rejects_requests_with_invalid_signature(): void
    {
        $account = Account::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $account->id,
        ]);
        $specialDate = SpecialDate::factory()->create([
            'account_id' => $account->id,
            'person_id' => $person->id,
        ]);

        $personIdHash = Crypt::encryptString((string) $person->id);
        $url = URL::signedRoute('reminder.stop', [
            'hash' => 3,
            'id' => $specialDate->id,
        ]);

        $response = $this->get($url);
        $response->assertStatus(302);
    }

    #[Test]
    public function it_handles_decryption_failure(): void
    {
        $account = Account::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $account->id,
        ]);
        $specialDate = SpecialDate::factory()->create([
            'account_id' => $account->id,
            'person_id' => $person->id,
        ]);

        $invalidHash = 'invalid-hash-value';
        $url = URL::signedRoute('reminder.stop', [
            'hash' => $invalidHash,
            'id' => $specialDate->id,
        ]);

        $response = $this->get($url);
        $response->assertRedirect();
        $response->assertSessionHasErrors();
    }

    #[Test]
    public function it_returns_404_when_person_not_found(): void
    {
        $nonExistentId = 999999;
        $specialDateId = 1;

        $personIdHash = Crypt::encryptString((string) $nonExistentId);
        $url = URL::signedRoute('reminder.stop', [
            'hash' => $personIdHash,
            'id' => $specialDateId,
        ]);

        $response = $this->get($url);
        $response->assertStatus(404);
    }

    #[Test]
    public function it_returns_404_when_special_date_not_found(): void
    {
        $account = Account::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $account->id,
        ]);
        $nonExistentSpecialDateId = 999999;

        $personIdHash = Crypt::encryptString((string) $person->id);
        $url = URL::signedRoute('reminder.stop', [
            'hash' => $personIdHash,
            'id' => $nonExistentSpecialDateId,
        ]);

        $response = $this->get($url);
        $response->assertStatus(404);
    }
}
