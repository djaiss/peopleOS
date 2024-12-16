<?php

namespace Tests\Unit\Models;

use App\Models\Address;
use App\Models\Company;
use App\Models\Contact;
use App\Models\ContactImportantDateType;
use App\Models\File;
use App\Models\Group;
use App\Models\Journal;
use App\Models\LifeEventCategory;
use App\Models\LifeMetric;
use App\Models\MoodTrackingParameter;
use App\Models\Tag;
use App\Models\Template;
use App\Models\TimelineEvent;
use App\Models\User;
use App\Models\Vault;
use App\Models\VaultQuickFactsTemplate;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class VaultTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_belongs_to_an_account(): void
    {
        $vault = Vault::factory()->create();
        $this->assertTrue($vault->account()->exists());
    }

    #[Test]
    public function it_has_many_users(): void
    {
        $dwight = User::factory()->create();
        $vault = Vault::factory()->create([
            'account_id' => $dwight->account_id,
        ]);
        $contact = Contact::factory()->create();

        $vault->users()->sync([$dwight->id => [
            'contact_id' => $contact->id,
        ]]);

        $this->assertTrue($vault->users()->exists());
    }

    #[Test]
    public function it_has_many_contacts(): void
    {
        $vault = Vault::factory()->create();
        Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);

        $this->assertTrue($vault->contacts()->exists());
    }

    #[Test]
    public function it_has_many_companies(): void
    {
        $vault = Vault::factory()->create();
        Company::factory()->create([
            'vault_id' => $vault->id,
        ]);

        $this->assertTrue($vault->companies()->exists());
    }
}
