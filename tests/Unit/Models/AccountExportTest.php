<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Enums\AgeType;
use App\Models\Account;
use App\Models\AccountExport;
use App\Models\EmailSent;
use App\Models\Encounter;
use App\Models\Gender;
use App\Models\Gift;
use App\Models\LifeEvent;
use App\Models\LoveRelationship;
use App\Models\Note;
use App\Models\Person;
use App\Models\SpecialDate;
use App\Models\Task;
use App\Models\WorkHistory;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AccountExportTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_belongs_to_an_account(): void
    {
        $account = Account::factory()->create();
        $accountExport = AccountExport::factory()->create([
            'account_id' => $account->id,
        ]);

        $this->assertTrue($accountExport->account()->exists());
    }
}
