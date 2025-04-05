<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Account;
use App\Models\Person;
use App\Models\User;
use App\Services\UpdatePersonPhysicalAppearance;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdatePersonPhysicalAppearanceTest extends TestCase
{
    use DatabaseTransactions;

    private Account $account;
    private User $user;
    private Person $person;

    #[Test]
    public function it_updates_physical_appearance_data(): void
    {
        Queue::fake();

        $this->createAccountAndUser();
        $this->createPerson();

        $request = [
            'height' => '5\'8"',
            'weight' => '130 lbs',
            'build' => 'slim',
            'skin_tone' => 'fair',
            'face_shape' => 'oval',
            'eye_color' => 'blue',
            'eye_shape' => 'almond',
            'hair_color' => 'blonde',
            'hair_type' => 'wavy',
            'hair_length' => 'long',
            'facial_hair' => 'none',
            'scars' => 'small scar on left cheek',
            'tatoos' => 'butterfly on ankle',
            'piercings' => 'ears, nose',
            'distinctive_marks' => 'birthmark on right shoulder',
            'glasses' => 'occasionally wears reading glasses',
            'dress_style' => 'bohemian',
            'voice' => 'melodic',
        ];

        (new UpdatePersonPhysicalAppearance(
            user: $this->user,
            person: $this->person,
            height: $request['height'],
            weight: $request['weight'],
            build: $request['build'],
            skin_tone: $request['skin_tone'],
            face_shape: $request['face_shape'],
            eye_color: $request['eye_color'],
            eye_shape: $request['eye_shape'],
            hair_color: $request['hair_color'],
            hair_type: $request['hair_type'],
            hair_length: $request['hair_length'],
            facial_hair: $request['facial_hair'],
            scars: $request['scars'],
            tatoos: $request['tatoos'],
            piercings: $request['piercings'],
            distinctive_marks: $request['distinctive_marks'],
            glasses: $request['glasses'],
            dress_style: $request['dress_style'],
            voice: $request['voice'],
        ))->execute();

        $person = $this->person->fresh();

        $this->assertEquals($request['height'], $person->height);
        $this->assertEquals($request['weight'], $person->weight);
        $this->assertEquals($request['build'], $person->build);
        $this->assertEquals($request['skin_tone'], $person->skin_tone);
        $this->assertEquals($request['face_shape'], $person->face_shape);
        $this->assertEquals($request['eye_color'], $person->eye_color);
        $this->assertEquals($request['eye_shape'], $person->eye_shape);
        $this->assertEquals($request['hair_color'], $person->hair_color);
        $this->assertEquals($request['hair_type'], $person->hair_type);
        $this->assertEquals($request['hair_length'], $person->hair_length);
        $this->assertEquals($request['facial_hair'], $person->facial_hair);
        $this->assertEquals($request['scars'], $person->scars);
        $this->assertEquals($request['tatoos'], $person->tatoos);
        $this->assertEquals($request['piercings'], $person->piercings);
        $this->assertEquals($request['distinctive_marks'], $person->distinctive_marks);
        $this->assertEquals($request['glasses'], $person->glasses);
        $this->assertEquals($request['dress_style'], $person->dress_style);
        $this->assertEquals($request['voice'], $person->voice);

        Queue::assertPushedOn(
            queue: 'low',
            job: UpdateUserLastActivityDate::class,
            callback: function ($job) {
                return $job->user->id === $this->user->id;
            }
        );

        Queue::assertPushedOn(
            queue: 'low',
            job: LogUserAction::class,
            callback: function ($job) {
                return $job->user->id === $this->user->id &&
                    $job->action === 'person_physical_appearance_update' &&
                    $job->description === 'Updated physical appearance for ' . $this->person->name;
            }
        );
    }

    #[Test]
    public function it_updates_only_provided_physical_appearance_fields(): void
    {
        Queue::fake();

        $this->createAccountAndUser();
        $this->createPerson();

        $this->person->update([
            'height' => '6\'0"',
            'weight' => '175 lbs',
            'build' => 'average',
            'skin_tone' => 'fair',
            'face_shape' => 'square',
            'eye_color' => 'blue',
        ]);

        (new UpdatePersonPhysicalAppearance(
            user: $this->user,
            person: $this->person,
            hair_color: 'brown',
            hair_type: 'straight',
            hair_length: 'short'
        ))->execute();

        $person = $this->person->fresh();

        // Assert only hair-related fields were updated
        $this->assertEquals('brown', $person->hair_color);
        $this->assertEquals('straight', $person->hair_type);
        $this->assertEquals('short', $person->hair_length);

        // And other fields are set to null
        $this->assertNull($person->height);
        $this->assertNull($person->weight);
        $this->assertNull($person->build);
        $this->assertNull($person->skin_tone);
        $this->assertNull($person->face_shape);
        $this->assertNull($person->eye_color);
    }

    #[Test]
    public function it_fails_if_user_doesnt_belong_to_same_account(): void
    {
        $this->createAccountAndUser();

        // Create another account with a person
        $anotherAccount = Account::factory()->create();
        $this->person = Person::factory()->create([
            'account_id' => $anotherAccount->id,
        ]);

        $this->expectException(ModelNotFoundException::class);

        (new UpdatePersonPhysicalAppearance(
            user: $this->user,
            person: $this->person,
            height: '5\'9"',
            weight: '180 lbs'
        ))->execute();
    }

    private function createAccountAndUser(): void
    {
        $this->account = Account::factory()->create();
        $this->user = User::factory()->create([
            'account_id' => $this->account->id,
        ]);
    }

    private function createPerson(): void
    {
        $this->person = Person::factory()->create([
            'account_id' => $this->account->id,
        ]);
    }
}
