<?php

namespace Tests\Unit\Models;

use App\Models\Contact;
use App\Models\MaritalStatus;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MaritalStatusTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_belongs_to_an_account(): void
    {
        $maritalStatus = MaritalStatus::factory()->create();
        $this->assertTrue($maritalStatus->account()->exists());
    }

    #[Test]
    public function it_gets_the_default_label(): void
    {
        $maritalStatus = MaritalStatus::factory()->create([
            'label' => null,
            'label_translation_key' => 'this is a default label',
        ]);

        $this->assertEquals(
            'this is a default label',
            $maritalStatus->getLabel()
        );
    }

    #[Test]
    public function it_gets_the_custom_label_if_defined(): void
    {
        $maritalStatus = MaritalStatus::factory()->create([
            'label' => 'this is the real label',
            'label_translation_key' => 'this is a default label',
        ]);

        $this->assertEquals(
            'this is the real label',
            $maritalStatus->getLabel()
        );
    }
}
