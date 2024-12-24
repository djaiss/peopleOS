<?php

namespace Tests\Unit\Services;

use App\Models\Template;
use App\Models\User;
use App\Services\CreateTemplate;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateTemplateTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_a_template(): void
    {
        $this->executeService();
    }

    private function executeService(): void
    {
        $user = User::factory()->create();

        $template = (new CreateTemplate(
            user: $user,
            name: 'Daily Reflection',
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
