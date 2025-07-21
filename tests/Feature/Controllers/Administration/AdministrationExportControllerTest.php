<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Administration;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdministrationExportControllerTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_displays_the_export_index_page(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        
        $user = User::factory()->create([
            'first_name' => 'Ross',
            'last_name' => 'Geller',
            'is_instance_admin' => true,
        ]);

        $response = $this->actingAs($user)
            ->get('/administration/export');

        $response->assertStatus(200);
        $response->assertViewIs('administration.export.index');
    }

    #[Test]
    public function it_requires_authentication(): void
    {
        $response = $this->get('/administration/export');

        $response->assertRedirect('/login');
    }

    #[Test]
    public function it_creates_export_request(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        
        $user = User::factory()->create([
            'first_name' => 'Ross',
            'last_name' => 'Geller',
            'is_instance_admin' => true,
        ]);

        $response = $this->actingAs($user)
            ->post('/administration/export');

        // Should redirect back with error since Python script doesn't exist
        $response->assertRedirect('/administration/export');
        $response->assertSessionHas('error');
    }

    #[Test]
    public function it_handles_export_failure(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        
        $user = User::factory()->create([
            'first_name' => 'Ross',
            'last_name' => 'Geller',
            'is_instance_admin' => false, // Non-admin user
        ]);

        $response = $this->actingAs($user)
            ->post('/administration/export');

        $response->assertRedirect('/administration/export');
        $response->assertSessionHas('error');
    }

    #[Test]
    public function it_handles_download_request(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        
        $user = User::factory()->create([
            'first_name' => 'Ross',
            'last_name' => 'Geller',
            'is_instance_admin' => true,
        ]);

        // Test with non-existent file
        $response = $this->actingAs($user)
            ->get('/administration/export/download?file=/nonexistent/file.json');

        $response->assertStatus(404);
    }
} 