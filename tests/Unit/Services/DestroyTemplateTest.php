<?php

namespace Tests\Unit\Services;

use App\Models\Template;
use App\Models\User;
use App\Services\DestroyTemplate;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DestroyTemplateTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_destroys_a_template(): void
    {
        $user = User::factory()->create();
        $template = Template::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $this->executeService($user, $template);
    }

    #[Test]
    public function it_fails_if_template_doesnt_belong_to_account(): void
    {
        $user = User::factory()->create();
        $template = Template::factory()->create();

        $this->expectException(ModelNotFoundException::class);
        $this->executeService($user, $template);
    }

    private function executeService(User $user, Template $template): void
    {
        (new DestroyTemplate(
            user: $user,
            template: $template,
        ))->execute();

        $this->assertDatabaseMissing('templates', [
            'id' => $template->id,
        ]);
    }
}
