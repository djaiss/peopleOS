<?php

namespace Tests\Unit\Models;

use App\Models\Partner;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PartnerTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_belongs_to_a_contact(): void
    {
        $partner = Partner::factory()->create();
        $this->assertTrue($partner->contact()->exists());
    }

    #[Test]
    public function it_belongs_to_a_marital_status(): void
    {
        $partner = Partner::factory()->create();
        $this->assertTrue($partner->maritalStatus()->exists());
    }
}
