<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\AccountExportStatus;
use App\Models\Account;
use App\Models\AccountExport;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ExportAccount
{
    private AccountExport $accountExport;

    public function __construct(
        public User $user,
        public Account $account,
    ) {}

    /**
     * Export the account as a SQL compatible file so user can upload it
     * in their own instance.
     */
    public function execute(): AccountExport
    {
        $this->validate();
        $this->startExport();
        $this->createFolder();

        return $this->accountExport;
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->account->id) {
            throw new \Exception('User does not belong to the account.');
        }
    }

    private function startExport(): void
    {
        $this->accountExport = AccountExport::create([
            'account_id' => $this->account->id,
            'status' => AccountExportStatus::STARTED->value,
            'uuid' => (string) Str::uuid(),
            'downloaded_at' => null,
        ]);
    }

    private function createFolder(): void
    {
        $folderName = 'exports/' . $this->accountExport->uuid;
        Storage::disk(config('filesystems.default'))->makeDirectory($folderName);
    }
}
