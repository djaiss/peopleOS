<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Administration;

use App\Models\Account;
use App\Models\JournalTemplate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class AdministrationPersonalizationJournalTemplateControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private Account $account;

    private string $validYaml = <<<'YAML'
template:
  name: "Daily Reflection"
  columns:
    - name: "Morning"
      questions:
        - name: "Sleep quality"
          answers:
            type: "range"
            range: [1, 5]
            comment_allowed: true
YAML;

    protected function setUp(): void
    {
        parent::setUp();

        $this->account = Account::factory()->create();
        $this->user = User::factory()->create([
            'account_id' => $this->account->id,
        ]);
    }

    #[Test]
    public function it_displays_the_new_template_page(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('administration.personalization.journal-templates.new'));

        $response->assertStatus(200);
        $response->assertViewIs('administration.personalization.journal-template-add');
    }

    #[Test]
    public function it_creates_a_journal_template(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('administration.personalization.journal-templates.create'), [
                'name' => 'Test Template',
                'content' => $this->validYaml,
            ]);

        $response->assertRedirect(route('administration.personalization.index'));
        $response->assertSessionHas('success');
    }

    #[Test]
    public function it_displays_the_edit_template_page(): void
    {
        $template = JournalTemplate::factory()->create([
            'account_id' => $this->account->id,
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('administration.personalization.journal-templates.edit', $template->id));

        $response->assertStatus(200);
        $response->assertViewIs('administration.personalization.journal-template-edit');
        $response->assertViewHas('journalTemplate');
    }

    #[Test]
    public function it_cant_edit_template_from_another_account(): void
    {
        $anotherAccount = Account::factory()->create();
        $template = JournalTemplate::factory()->create([
            'account_id' => $anotherAccount->id,
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('administration.personalization.journal-templates.edit', $template->id));

        $response->assertStatus(404);
    }

    #[Test]
    public function it_updates_a_journal_template(): void
    {
        $template = JournalTemplate::factory()->create([
            'account_id' => $this->account->id,
        ]);

        $response = $this->actingAs($this->user)
            ->put(route('administration.personalization.journal-templates.update', $template->id), [
                'name' => 'Updated Template',
                'content' => $this->validYaml,
            ]);

        $response->assertRedirect(route('administration.personalization.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('journal_templates', [
            'id' => $template->id,
        ]);
    }

    #[Test]
    public function it_deletes_a_journal_template(): void
    {
        $template = JournalTemplate::factory()->create([
            'account_id' => $this->account->id,
        ]);

        $response = $this->actingAs($this->user)
            ->delete(route('administration.personalization.journal-templates.destroy', $template->id));

        $response->assertRedirect(route('administration.personalization.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('journal_templates', [
            'id' => $template->id,
        ]);
    }

    #[Test]
    public function it_validates_required_fields_when_creating(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('administration.personalization.journal-templates.create'), [
                'name' => '',
                'content' => '',
            ]);

        $response->assertSessionHasErrors(['name', 'content']);
    }

    #[Test]
    public function it_validates_required_fields_when_updating(): void
    {
        $template = JournalTemplate::factory()->create([
            'account_id' => $this->account->id,
        ]);

        $response = $this->actingAs($this->user)
            ->put(route('administration.personalization.journal-templates.update', $template->id), [
                'name' => '',
                'content' => '',
            ]);

        $response->assertSessionHasErrors(['name', 'content']);
    }
}
