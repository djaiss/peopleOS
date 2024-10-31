<?php

namespace Tests\Feature\Controllers\Vaults;

use App\Models\User;
use App\Models\Vault;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Masmerise\Toaster\Toaster;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class VaultControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function the_vault_index_page_contains_all_the_necessary_data(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();
        $vault = $this->createVault($user);

        $response = $this->actingAs($user)
            ->get('/vaults')
            ->assertOk();

        $this->assertArrayHasKey('vaults', $response);
        $this->assertArrayHasKey('routes', $response);

        $this->assertCount(1, $response['routes']);
        $this->assertCount(1, $response['vaults']);

        $this->assertEquals(
            [
                'id' => $vault->id,
                'name' => $vault->name,
                'description' => $vault->description,
                'updated_at' => '0 seconds ago',
                'routes' => [
                    'vault' => [
                        'show' => env('APP_URL').'/vaults/'.$vault->id,
                    ],
                ],
            ],
            $response['vaults']->toArray()[0]
        );

        $this->assertEquals(
            env('APP_URL').'/new',
            $response['routes']['vault']['new']
        );
    }

    #[Test]
    public function a_user_can_visit_the_create_vault_page(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/new')
            ->assertOk();
    }

    #[Test]
    public function a_user_can_create_a_vault(): void
    {
        Toaster::fake();
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/new', [
                'name' => 'Super vault',
                'description' => 'this is the description',
            ])
            ->assertRedirectToRoute('vaults.show', ['vault' => Vault::first()]);

        Toaster::assertDispatched('The vault has been created');
    }

    #[Test]
    public function a_user_can_visit_the_vault_page(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);

        $response = $this->actingAs($user)
            ->get('/vaults/'.$vault->id)
            ->assertOk();

        $this->assertArrayHasKey('vault', $response);
        $this->assertEquals($vault->id, $response['vault']['id']);
    }

    #[Test]
    public function a_user_can_visit_the_delete_vault_page(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);

        $this->actingAs($user)
            ->get('/vaults/'.$vault->id.'/settings')
            ->assertSeeText('Delete the vault')
            ->assertOk();
    }

    #[Test]
    public function a_user_can_delete_a_vault(): void
    {
        Toaster::fake();
        $user = User::factory()->create();
        $vault = $this->createVault($user);

        $this->actingAs($user)
            ->delete('/vaults/'.$vault->id)
            ->assertRedirectToRoute('vaults.index');

        Toaster::assertDispatched('The vault has been deleted');
    }
}
