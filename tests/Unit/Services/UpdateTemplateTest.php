<?php

namespace Tests\Unit\Services;

use App\Models\Template;
use App\Models\User;
use App\Services\UpdateTemplate;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateTemplateTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_a_template(): void
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
        $template = (new UpdateTemplate(
            user: $user,
            template: $template,
            name: 'Dunder mifflin',
            content: <<<'YAML'
template:
  name: "Daily Reflection"
  columns:
    - name: "General Overview"
      questions:
        - name: "Test Question"
          answers:
            type: "range"
            range: [1, 4]
            comment_allowed: false
YAML,
        ))->execute();

        $this->assertDatabaseHas('templates', [
            'id' => $template->id,
        ]);

        $this->assertInstanceOf(
            Template::class,
            $template
        );
    }
}
