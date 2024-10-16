<?php

namespace Tests\Unit\Models;

use App\Models\Address;
use App\Models\Company;
use App\Models\Contact;
use App\Models\ContactImportantDateType;
use App\Models\File;
use App\Models\Gender;
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

class GenderTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_belongs_to_an_account()
    {
        $gender = Gender::factory()->create();
        $this->assertTrue($gender->account()->exists());
    }

    #[Test]
    public function it_gets_the_default_label()
    {
        $gender = Gender::factory()->create([
            'label' => null,
            'label_translation_key' => 'this is a default label',
        ]);

        $this->assertEquals(
            'this is a default label',
            $gender->label
        );
    }

    #[Test]
    public function it_gets_the_custom_label_if_defined()
    {
        $gender = Gender::factory()->create([
            'label' => 'this is the real label',
            'label_translation_key' => 'this is a default label',
        ]);

        $this->assertEquals(
            'this is the real label',
            $gender->label
        );
    }
}
