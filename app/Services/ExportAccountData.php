<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;

/**
 * Export account data using Python script.
 */
class ExportAccountData
{
    private string $outputPath;

    public function __construct(
        public User $user,
    ) {}

    public function execute(): string
    {
        $this->validate();
        $this->createOutputDirectory();
        $this->runExportScript();
        $this->logUserAction();

        return $this->outputPath;
    }

    private function validate(): void
    {
        // Ensure user has permission to export data
        if (!$this->user->is_instance_admin) {
            throw new \Exception('User does not have permission to export data');
        }
    }

    private function createOutputDirectory(): void
    {
        $exportDir = storage_path('app/exports');
        if (!file_exists($exportDir)) {
            mkdir($exportDir, 0755, true);
        }
    }

    private function runExportScript(): void
    {
        $this->outputPath = storage_path('app/exports/account_' . $this->user->account_id . '_' . now()->format('Y-m-d_H-i-s') . '.json');

        $scriptPath = base_path('scripts/export_account_data.py');
        
        if (!file_exists($scriptPath)) {
            throw new \Exception('Export script not found');
        }

        $process = new Process([
            'python3',
            $scriptPath,
            '--account-id', (string) $this->user->account_id,
            '--output', $this->outputPath,
            '--host', config('database.connections.mysql.host'),
            '--port', (string) config('database.connections.mysql.port'),
            '--database', config('database.connections.mysql.database'),
            '--username', config('database.connections.mysql.username'),
            '--password', config('database.connections.mysql.password'),
        ]);

        $process->setTimeout(300); // 5 minutes timeout

        $process->run();

        if (!$process->isSuccessful()) {
            throw new \Exception('Export failed: ' . $process->getErrorOutput());
        }

        if (!file_exists($this->outputPath)) {
            throw new \Exception('Export file was not created');
        }
    }

    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'account_data_export',
            description: 'Exported account data to ' . basename($this->outputPath),
        )->onQueue('low');
    }
} 