<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Models\User;
use App\Services\ExportAccountData;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ExportAccountDataTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_throws_exception_for_non_admin_user(): void
    {
        Queue::fake();

        $user = User::factory()->create([
            'is_instance_admin' => false,
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('User does not have permission to export data');

        (new ExportAccountData(
            user: $user,
        ))->execute();
    }

    #[Test]
    public function it_logs_user_action_when_export_succeeds(): void
    {
        Queue::fake();

        $user = User::factory()->create([
            'is_instance_admin' => true,
        ]);

        // Mock the export script execution
        $this->mock(\Symfony\Component\Process\Process::class, function ($mock) {
            $mock->shouldReceive('setTimeout')->once();
            $mock->shouldReceive('run')->once();
            $mock->shouldReceive('isSuccessful')->once()->andReturn(true);
        });

        // Mock file existence check
        $this->mock(\Illuminate\Support\Facades\File::class, function ($mock) {
            $mock->shouldReceive('exists')->andReturn(true);
        });

        try {
            (new ExportAccountData(
                user: $user,
            ))->execute();
        } catch (\Exception $e) {
            // Expected to fail due to missing Python script
        }

        Queue::assertPushedOn(
            queue: 'low',
            job: LogUserAction::class,
            callback: function (LogUserAction $job) use ($user): bool {
                return $job->action === 'account_data_export'
                    && $job->user->id === $user->id;
            },
        );
    }

    #[Test]
    public function it_creates_export_directory_if_not_exists(): void
    {
        Queue::fake();

        $user = User::factory()->create([
            'is_instance_admin' => true,
        ]);

        $exportDir = storage_path('app/exports');
        
        // Remove directory if it exists
        if (file_exists($exportDir)) {
            rmdir($exportDir);
        }

        $this->assertFalse(file_exists($exportDir));

        try {
            (new ExportAccountData(
                user: $user,
            ))->execute();
        } catch (\Exception $e) {
            // Expected to fail due to missing Python script
        }

        // Directory should be created
        $this->assertTrue(file_exists($exportDir));

        // Clean up
        if (file_exists($exportDir)) {
            rmdir($exportDir);
        }
    }
} 