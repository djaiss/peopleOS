<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Administration;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdministrationCreateTaskOnReminderControllerTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_create_task_on_reminder_setting_to_true(): void
    {
        $account = Account::factory()->create([
            'create_task_on_reminder' => false,
        ]);

        $user = User::factory()->create([
            'account_id' => $account->id,
        ]);

        $this->actingAs($user);

        $response = $this->put(route('administration.personalization.create-task-on-reminder.update'), [
            'create_task_on_reminder' => 'yes',
        ]);

        $response->assertRedirect(route('administration.personalization.index'));
        $response->assertSessionHas('status', trans('Changes saved'));

        $this->assertTrue($account->fresh()->create_task_on_reminder);
    }

    #[Test]
    public function it_updates_create_task_on_reminder_setting_to_false(): void
    {
        $account = Account::factory()->create([
            'create_task_on_reminder' => true,
        ]);

        $user = User::factory()->create([
            'account_id' => $account->id,
        ]);

        $this->actingAs($user);

        $response = $this->put(route('administration.personalization.create-task-on-reminder.update'), [
            'create_task_on_reminder' => 'no',
        ]);

        $response->assertRedirect(route('administration.personalization.index'));
        $response->assertSessionHas('status', trans('Changes saved'));

        $this->assertFalse($account->fresh()->create_task_on_reminder);
    }

    #[Test]
    public function it_validates_create_task_on_reminder_input(): void
    {
        $account = Account::factory()->create();

        $user = User::factory()->create([
            'account_id' => $account->id,
        ]);

        $this->actingAs($user);

        $response = $this->put(route('administration.personalization.create-task-on-reminder.update'), [
            'create_task_on_reminder' => 'invalid-value',
        ]);

        $response->assertSessionHasErrors('create_task_on_reminder');
    }
}
