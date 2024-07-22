<?php

namespace Tests\Unit\Models;

use App\Models\Company;
use App\Models\Contact;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_belongs_to_a_vault()
    {
        $company = Company::factory()->create();
        $this->assertTrue($company->vault()->exists());
    }

    #[Test]
    public function it_has_many_contacts(): void
    {
        $company = Company::factory()->create();
        Contact::factory()->create([
            'company_id' => $company->id,
        ]);

        $this->assertTrue($company->contacts()->exists());
    }
}
