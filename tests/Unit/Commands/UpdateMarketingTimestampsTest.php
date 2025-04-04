<?php

namespace Tests\Unit\Commands;

use Illuminate\Support\Facades\File;
use Tests\TestCase;

class UpdateMarketingTimestampsTest extends TestCase
{
    public function test_command_outputs_confirmation_message()
    {
        // Mock the output of the service
        File::shouldReceive('isDirectory')->andReturn(false); // so execute() does nothing
        File::shouldReceive('put')->never();

        $this->artisan('marketing:update-timestamps')
            ->expectsOutput('Marketing page timestamps updated.')
            ->assertExitCode(0);
    }
}
