<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Enums\AccountExportStatus;
use App\Models\Account;
use App\Models\AccountExport;
use App\Models\User;
use App\Services\ExportAccount;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ExportAccountTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_should_create_an_export(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-03-17 10:00:00'));
        Storage::fake();

        $account = Account::factory()->create();
        $user = User::factory()->create([
            'account_id' => $account->id,
        ]);

        $export = (new ExportAccount(
            user: $user,
            account: $account,
        ))->execute();

        $this->assertInstanceOf(
            AccountExport::class,
            $export
        );

        $this->assertEquals(
            $account->id,
            $export->account_id
        );

        $this->assertEquals(
            AccountExportStatus::STARTED->value,
            $export->status
        );

        $this->assertNull($export->downloaded_at);

        $this->assertTrue(Storage::disk(config('filesystems.default'))->exists('exports/' . $export->uuid));
    }

    #[Test]
    public function it_should_throw_an_exception_when_user_does_not_belong_to_account(): void
    {
        $account = Account::factory()->create();
        $user = User::factory()->create([
            'account_id' => Account::factory()->create()->id,
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('User does not belong to the account.');

        (new ExportAccount(
            user: $user,
            account: $account,
        ))->execute();
    }
}
