<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\EmailSent;
use App\Models\Person;
use App\Models\User;
use App\Services\CreateEmailSent;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateEmailSentTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_an_email_sent(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Monica',
            'last_name' => 'Geller',
        ]);

        $emailSent = (new CreateEmailSent(
            user: $user,
            person: $person,
            emailType: 'birthday_wishes',
            emailAddress: 'monica.geller@friends.com',
            subject: 'Happy Birthday!',
            body: 'Hope you have a great day!',
        ))->execute();

        $this->assertDatabaseHas('emails_sent', [
            'id' => $emailSent->id,
            'account_id' => $user->account_id,
            'person_id' => $person->id,
        ]);

        $this->assertEquals(36, mb_strlen($emailSent->uuid));
        $this->assertEquals('birthday_wishes', $emailSent->email_type);
        $this->assertEquals('Happy Birthday!', $emailSent->subject);
        $this->assertEquals('monica.geller@friends.com', $emailSent->email_address);
        $this->assertEquals('Hope you have a great day!', $emailSent->body);

        $this->assertInstanceOf(
            EmailSent::class,
            $emailSent
        );
    }

    #[Test]
    public function it_creates_an_email_sent_without_person(): void
    {
        Queue::fake();

        $user = User::factory()->create();

        $emailSent = (new CreateEmailSent(
            user: $user,
            person: null,
            emailType: 'newsletter',
            emailAddress: 'chandler.bing@friends.com',
            subject: 'Monthly Newsletter',
            body: 'Here are the latest updates...',
        ))->execute();

        $this->assertDatabaseHas('emails_sent', [
            'id' => $emailSent->id,
            'account_id' => $user->account_id,
            'person_id' => null,
        ]);

        $this->assertEquals('Monthly Newsletter', $emailSent->subject);
        $this->assertEquals('chandler.bing@friends.com', $emailSent->email_address);
        $this->assertEquals('Here are the latest updates...', $emailSent->body);
    }

    #[Test]
    public function it_fails_if_person_doesnt_belong_to_account(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $user = User::factory()->create();
        $person = Person::factory()->create();

        (new CreateEmailSent(
            user: $user,
            person: $person,
            emailType: 'birthday_wishes',
            emailAddress: 'monica.geller@friends.com',
            subject: 'Happy Birthday!',
            body: 'Hope you have a great day!',
        ))->execute();
    }
}
