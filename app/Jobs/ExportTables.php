<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Account;
use App\Models\AccountExport;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Database\Eloquent\Model;

class ExportTables implements ShouldQueue
{
    use Queueable;

    public string $fileName;

    public function __construct(
        public AccountExport $accountExport,
    ) {}

    /**
     * Export all the tables in the database to a file.
     * We can not export data so it can be imported directly, since data needs
     * to be encrypted before being stored in the database. This sucks.
     *
     * The exported file will be a big fat array. The first keys will be the
     * table names, and the values will be the data in the table.
     */
    public function handle(): void
    {
        $folderName = 'exports/' . $this->accountExport->uuid;
        $this->fileName = $folderName . '/export.json';

        $this->exportAccountTable();
    }

    public function exportAccountTable(): void
    {
        $account = Account::find($this->accountExport->account_id);

        if ($account === null) {
            throw new \Exception('Account not found.');
        }

        $handle = fopen($this->fileName, 'w');
        fwrite($handle, "{\n  \"accounts\": [\n");
        $row = $this->modelToJsonString($account);
        fwrite($handle, "    " . $row);
        fwrite($handle, "\n  ]\n}");
        fclose($handle);
    }

    /**
     * Convert a model to a formatted JSON string representation
     *
     * Handles long text values with line breaks and preserves encrypted values
     * while ensuring proper Unicode character handling.
     */
    public function modelToJsonString(Model $model, array $excludeFields = []): string
    {
        $modelArray = $model->toArray();

        // Remove excluded fields
        foreach ($excludeFields as $field) {
            if (isset($modelArray[$field])) {
                unset($modelArray[$field]);
            }
        }

        // Set JSON encoding options:
        // - JSON_UNESCAPED_UNICODE: Preserve non-ASCII characters
        // - JSON_UNESCAPED_SLASHES: Don't escape forward slashes in URLs
        // - JSON_HEX_TAG, JSON_HEX_AMP, etc.: Properly encode HTML entities
        //   which helps with text containing line breaks and special characters
        $jsonOptions = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES |
                      JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT;

        // Convert to JSON string with appropriate formatting
        return json_encode($modelArray, $jsonOptions);
    }
}
