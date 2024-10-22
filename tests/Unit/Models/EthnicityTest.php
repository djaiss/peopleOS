<?php

namespace Tests\Unit\Models;

use App\Models\Contact;
use App\Models\Ethnicity;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class EthnicityTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_belongs_to_an_account(): void
    {
        $ethnicity = Ethnicity::factory()->create();
        $this->assertTrue($ethnicity->account()->exists());
    }

    #[Test]
    public function it_has_many_contacts(): void
    {
        $ethnicity = Ethnicity::factory()->create();
        Contact::factory()->create([
            'ethnicity_id' => $ethnicity->id,
        ]);

        $this->assertTrue($ethnicity->contacts()->exists());
    }

    #[Test]
    public function it_gets_the_default_label(): void
    {
        $ethnicity = Ethnicity::factory()->create([
            'label' => null,
            'label_translation_key' => 'this is a default label',
        ]);

        $this->assertEquals(
            'this is a default label',
            $ethnicity->getLabel()
        );
    }

    #[Test]
    public function it_gets_the_custom_label_if_defined(): void
    {
        $ethnicity = Ethnicity::factory()->create([
            'label' => 'this is the real label',
            'label_translation_key' => 'this is a default label',
        ]);

        $this->assertEquals(
            'this is the real label',
            $ethnicity->getLabel()
        );
    }
}
