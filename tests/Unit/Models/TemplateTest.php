<?php

namespace Tests\Unit\Models;

use App\Models\Account;
use App\Models\Template;
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
