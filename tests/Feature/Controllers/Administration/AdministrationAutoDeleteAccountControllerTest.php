<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Administration;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdministrationAutoDeleteAccountControllerTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_auto_delete_account_setting_to_true(): void
    {
        $account = Account::factory()->create([
            'auto_delete_account' => false,
        ]);

        $user = User::factory()->create([
            'account_id' => $account->id,
        ]);

        $this->actingAs($user);

        $response = $this->put(route('administration.security.auto-delete.update'), [
            'auto_delete_account' => 'yes',
        ]);

        $response->assertRedirect(route('administration.security.index'));
        $response->assertSessionHas('status', trans('Changes saved'));

        $this->assertTrue($account->fresh()->auto_delete_account);
    }

    #[Test]
    public function it_updates_auto_delete_account_setting_to_false(): void
    {
        $account = Account::factory()->create([
            'auto_delete_account' => true,
        ]);

        $user = User::factory()->create([
            'account_id' => $account->id,
        ]);

        $this->actingAs($user);

        $response = $this->put(route('administration.security.auto-delete.update'), [
            'auto_delete_account' => 'no',
        ]);

        $response->assertRedirect(route('administration.security.index'));
        $response->assertSessionHas('status', trans('Changes saved'));

        $this->assertFalse($account->fresh()->auto_delete_account);
    }

    #[Test]
    public function it_validates_auto_delete_account_input(): void
    {
        $account = Account::factory()->create();

        $user = User::factory()->create([
            'account_id' => $account->id,
        ]);

        $this->actingAs($user);

        $response = $this->put(route('administration.security.auto-delete.update'), [
            'auto_delete_account' => 'invalid-value',
        ]);

        $response->assertSessionHasErrors('auto_delete_account');
    }
}
