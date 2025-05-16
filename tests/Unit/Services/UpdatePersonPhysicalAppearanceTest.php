<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Account;
use App\Models\Person;
use App\Models\User;
use App\Services\UpdatePersonPhysicalAppearance;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdatePersonPhysicalAppearanceTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_all_physical_appearance_attributes(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-04-05 14:30:00'));

        $account = Account::factory()->create();
        $user = User::factory()->create([
            'account_id' => $account->id,
        ]);
        $person = Person::factory()->create([
            'account_id' => $account->id,
            'first_name' => 'Rachel',
            'last_name' => 'Green',
        ]);

        Queue::fake();

        $service = new UpdatePersonPhysicalAppearance(
            user: $user,
            person: $person,
            height: '5\'6"',
            weight: '120 lbs',
            build: 'slim',
            skin_tone: 'fair',
            face_shape: 'oval',
            eye_color: 'blue',
            eye_shape: 'almond',
            hair_color: 'blonde',
            hair_type: 'straight',
            hair_length: 'shoulder-length',
            facial_hair: 'none',
            scars: 'small scar on right elbow',
            tatoos: 'small star on wrist',
            piercings: 'ears, belly button',
            distinctive_marks: 'beauty mark above lip',
            glasses: 'occasionally wears reading glasses',
            dress_style: 'fashionable, trendy',
            voice: 'soft, sometimes nasal when excited',
        );

        $person = $service->execute();

        $this->assertEquals('5\'6"', $person->height);
        $this->assertEquals('120 lbs', $person->weight);
        $this->assertEquals('slim', $person->build);
        $this->assertEquals('fair', $person->skin_tone);
        $this->assertEquals('oval', $person->face_shape);
        $this->assertEquals('blue', $person->eye_color);
        $this->assertEquals('almond', $person->eye_shape);
        $this->assertEquals('blonde', $person->hair_color);
        $this->assertEquals('straight', $person->hair_type);
        $this->assertEquals('shoulder-length', $person->hair_length);
        $this->assertEquals('none', $person->facial_hair);
        $this->assertEquals('small scar on right elbow', $person->scars);
        $this->assertEquals('small star on wrist', $person->tatoos);
        $this->assertEquals('ears, belly button', $person->piercings);
        $this->assertEquals('beauty mark above lip', $person->distinctive_marks);
        $this->assertEquals('occasionally wears reading glasses', $person->glasses);
        $this->assertEquals('fashionable, trendy', $person->dress_style);
        $this->assertEquals(
            'soft, sometimes nasal when excited',
            $person->voice
        );

        Queue::assertPushedOn(
            'low',
            UpdateUserLastActivityDate::class,
            function ($job) use ($user) {
                return $job->user->id === $user->id;
            }
        );

        Queue::assertPushedOn(
            'low',
            UpdatePersonLastConsultedDate::class,
            function ($job) use ($person) {
                return $job->person->id === $person->id;
            }
        );

        Queue::assertPushedOn(
            'low',
            LogUserAction::class,
            function ($job) use ($user) {
                return $job->user->id === $user->id &&
                    $job->action === 'person_physical_appearance_update' &&
                    $job->description === 'Updated physical appearance for Rachel Green';
            }
        );
    }

    #[Test]
    public function it_updates_only_specified_attributes(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-04-05 16:45:00'));

        $account = Account::factory()->create();
        $user = User::factory()->create([
            'account_id' => $account->id,
        ]);
        $person = Person::factory()->create([
            'account_id' => $account->id,
            'first_name' => 'Chandler',
            'last_name' => 'Bing',
            'height' => '6\'0"',
            'weight' => '175 lbs',
            'build' => 'average',
            'hair_color' => 'brown',
            'hair_type' => 'straight',
            'hair_length' => 'medium',
        ]);

        Queue::fake();

        $service = new UpdatePersonPhysicalAppearance(
            user: $user,
            person: $person,
            hair_length: 'very short',
            hair_type: 'spiky',
        );

        $person = $service->execute();

        // Assert updated fields
        $this->assertEquals('very short', $person->hair_length);
        $this->assertEquals('spiky', $person->hair_type);

        // Assert other fields are null
        $this->assertNull($person->height);
        $this->assertNull($person->weight);
        $this->assertNull($person->build);
        $this->assertNull($person->skin_tone);
        $this->assertNull($person->face_shape);
        $this->assertNull($person->eye_color);
        $this->assertNull($person->eye_shape);
        $this->assertNull($person->facial_hair);
        $this->assertNull($person->scars);
        $this->assertNull($person->tatoos);
        $this->assertNull($person->piercings);
        $this->assertNull($person->distinctive_marks);
        $this->assertNull($person->glasses);
        $this->assertNull($person->dress_style);
        $this->assertNull($person->voice);

        Queue::assertPushedOn(
            'low',
            LogUserAction::class,
            function ($job) {
                return $job->action === 'person_physical_appearance_update';
            }
        );
    }

    #[Test]
    public function it_throws_exception_when_user_is_not_from_same_account(): void
    {
        // Joey tries to update Monica's appearance but they're from different accounts
        Carbon::setTestNow(Carbon::parse('2025-04-05 18:20:00'));

        $joeyAccount = Account::factory()->create();
        $joeyUser = User::factory()->create([
            'account_id' => $joeyAccount->id,
        ]);

        $monicaAccount = Account::factory()->create();
        $monica = Person::factory()->create([
            'account_id' => $monicaAccount->id,
            'first_name' => 'Monica',
            'last_name' => 'Geller',
        ]);

        $this->expectException(ModelNotFoundException::class);

        $service = new UpdatePersonPhysicalAppearance(
            user: $joeyUser,
            person: $monica,
            height: '5\'5"',
            weight: '125 lbs',
        );

        $service->execute();
    }
}
