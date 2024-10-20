<?php

namespace Tests\Unit\Models;

use App\Models\Contact;
use App\Models\Gender;
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
    public function it_has_many_contacts(): void
    {
        $gender = Gender::factory()->create();
        Contact::factory()->create([
            'gender_id' => $gender->id,
        ]);

        $this->assertTrue($gender->contacts()->exists());
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
            $gender->getLabel()
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
            $gender->getLabel()
        );
    }
}
