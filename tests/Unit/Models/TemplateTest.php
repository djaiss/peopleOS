<?php

namespace Tests\Unit\Models;

use App\Models\Account;
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

class TemplateTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_belongs_to_an_account(): void
    {
        $account = Account::factory()->create();
        $template = Template::factory()->create([
            'account_id' => $account->id,
        ]);
        $this->assertTrue($template->account()->exists());
    }
}
