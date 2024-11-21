<?php

namespace Tests\Unit\Services;

use App\Enums\ChildGender;
use App\Models\Child;
use App\Models\Contact;
use App\Models\User;
use App\Models\Vault;
use App\Services\UpdateChild;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateChildTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_a_child(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $child = Child::factory()->create([
            'contact_id' => $contact->id,
        ]);
        $this->executeService($user, $child);
    }

    #[Test]
    public function it_fails_if_vault_doesnt_belong_to_account(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $vault = Vault::factory()->create();
        $user = User::factory()->create();
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $child = Child::factory()->create([
            'contact_id' => $contact->id,
        ]);
        $this->executeService($user, $child);
    }

    #[Test]
    public function it_fails_if_contact_doesnt_belong_to_vault(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $vault = Vault::factory()->create();
        $user = User::factory()->create();
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $child = Child::factory()->create([
            'contact_id' => $contact->id,
        ]);
        $this->executeService($user, $child);
    }

    #[Test]
    public function it_fails_if_child_doesnt_belong_to_contact(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $user = User::factory()->create();
        $child = Child::factory()->create();
        $this->executeService($user, $child);
    }

    private function executeService(User $user, Child $child): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));

        $child = (new UpdateChild(
            user: $user,
            child: $child,
            name: 'John',
            gender: ChildGender::BOY->value,
            age: 10,
            gradeLevel: '10th',
            school: 'High School',
        ))->execute();

        $this->assertDatabaseHas('children', [
            'id' => $child->id,
        ]);

        $this->assertInstanceOf(
            Child::class,
            $child
        );

        $this->assertEquals(
            'John',
            $child->name
        );
        $this->assertEquals(
            ChildGender::BOY->value,
            $child->gender
        );
        $this->assertEquals(
            10,
            $child->age
        );
        $this->assertEquals(
            '10th',
            $child->grade_level
        );
        $this->assertEquals(
            'High School',
            $child->school
        );
    }
}
