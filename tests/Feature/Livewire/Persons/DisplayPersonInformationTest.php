<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Persons;

use App\Livewire\Persons\DisplayPersonInformation;
use App\Models\Person;
use App\Models\User;
use App\Models\WorkHistory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DisplayPersonInformationTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function the_component_renders(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Chandler',
            'last_name' => 'Bing',
        ]);

        $component = Livewire::actingAs($user)
            ->test(DisplayPersonInformation::class, [
                'person' => $person,
            ]);

        $component->assertOk();
    }

    #[Test]
    public function it_displays_person_title_from_active_work_history(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Joey',
            'last_name' => 'Tribbiani',
        ]);

        WorkHistory::factory()->create([
            'person_id' => $person->id,
            'job_title' => 'Actor',
            'company_name' => 'Days of Our Lives',
            'active' => true,
        ]);

        $component = Livewire::actingAs($user)
            ->test(DisplayPersonInformation::class, [
                'person' => $person,
            ]);

        $component->assertSet('title', 'Actor');
    }

    #[Test]
    public function it_refreshes_person_information_when_work_history_is_updated(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Chandler',
            'last_name' => 'Bing',
        ]);

        $workHistory = WorkHistory::factory()->create([
            'person_id' => $person->id,
            'job_title' => 'Data Analyst',
            'active' => true,
        ]);

        $component = Livewire::actingAs($user)
            ->test(DisplayPersonInformation::class, [
                'person' => $person,
            ]);

        $component->assertSet('title', 'Data Analyst');

        // Update work history through the database
        $workHistory->update([
            'job_title' => 'Statistical Analysis and Data Reconfiguration',
        ]);

        // Dispatch the event that would normally be triggered by the work history update
        $component->dispatch('work-history-updated');

        $component->assertSet('title', 'Statistical Analysis and Data Reconfiguration');
    }

    #[Test]
    public function it_handles_multiple_work_histories_correctly(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Rachel',
            'last_name' => 'Green',
        ]);

        // Create inactive work history
        WorkHistory::factory()->create([
            'person_id' => $person->id,
            'job_title' => 'Waitress',
            'company_name' => 'Central Perk',
            'active' => false,
        ]);

        // Create active work history
        WorkHistory::factory()->create([
            'person_id' => $person->id,
            'job_title' => 'Buyer',
            'company_name' => 'Ralph Lauren',
            'active' => true,
        ]);

        $component = Livewire::actingAs($user)
            ->test(DisplayPersonInformation::class, [
                'person' => $person,
            ]);

        $component->assertSet('title', 'Buyer');
    }
}
