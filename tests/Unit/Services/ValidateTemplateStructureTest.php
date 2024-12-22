<?php

namespace Tests\Unit\Services;

use App\Exceptions\InvalidTemplateStructureException;
use App\Services\ValidateTemplateStructure;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ValidateTemplateStructureTest extends TestCase
{
    use DatabaseTransactions;

    private string $validTemplate = <<<YAML
template:
  name: "Daily Reflection"
  columns:
    - name: "General Overview"
      questions:
        - name: "Have you spent a good day?"
          answers:
            type: "choice"
            options: ["YES", "NO"]
            comment_allowed: true
YAML;

    #[Test]
    public function it_validates_a_correct_template(): void
    {
        $result = (new ValidateTemplateStructure(
            yamlContent: $this->validTemplate
        ))->execute();

        $this->assertTrue($result);
    }

    #[Test]
    public function it_fails_if_template_root_is_missing(): void
    {
        $this->expectException(InvalidTemplateStructureException::class);
        $this->expectExceptionMessage('Missing template root element');

        $yaml = <<<YAML
name: "Daily Reflection"
columns: []
YAML;

        (new ValidateTemplateStructure($yaml))->execute();
    }

    #[Test]
    public function it_fails_if_template_name_is_missing(): void
    {
        $this->expectException(InvalidTemplateStructureException::class);
        $this->expectExceptionMessage('Template name is required');

        $yaml = <<<YAML
template:
  columns: []
YAML;

        (new ValidateTemplateStructure($yaml))->execute();
    }

    #[Test]
    public function it_fails_if_columns_are_missing(): void
    {
        $this->expectException(InvalidTemplateStructureException::class);
        $this->expectExceptionMessage('Template must contain columns array');

        $yaml = <<<YAML
template:
  name: "Daily Reflection"
YAML;

        (new ValidateTemplateStructure($yaml))->execute();
    }

    #[Test]
    public function it_fails_if_column_name_is_missing(): void
    {
        $this->expectException(InvalidTemplateStructureException::class);
        $this->expectExceptionMessage('Column at index 0 must have a name');

        $yaml = <<<YAML
template:
  name: "Daily Reflection"
  columns:
    - questions:
        - name: "Question 1"
          answers:
            type: "textarea"
            comment_allowed: false
YAML;

        (new ValidateTemplateStructure($yaml))->execute();
    }

    #[Test]
    public function it_fails_if_questions_are_missing_in_column(): void
    {
        $this->expectException(InvalidTemplateStructureException::class);
        $this->expectExceptionMessage("Column 'General Overview' must contain questions array");

        $yaml = <<<YAML
template:
  name: "Daily Reflection"
  columns:
    - name: "General Overview"
YAML;

        (new ValidateTemplateStructure($yaml))->execute();
    }

    #[Test]
    public function it_fails_if_question_name_is_missing(): void
    {
        $this->expectException(InvalidTemplateStructureException::class);
        $this->expectExceptionMessage("Question at index 0 in column 'General Overview' must have a name");

        $yaml = <<<YAML
template:
  name: "Daily Reflection"
  columns:
    - name: "General Overview"
      questions:
        - answers:
            type: "textarea"
            comment_allowed: false
YAML;

        (new ValidateTemplateStructure($yaml))->execute();
    }

    #[Test]
    public function it_fails_if_answer_type_is_invalid(): void
    {
        $this->expectException(InvalidTemplateStructureException::class);
        $this->expectExceptionMessage("Invalid answer type 'invalid_type' for question 'Test Question'");

        $yaml = <<<YAML
template:
  name: "Daily Reflection"
  columns:
    - name: "General Overview"
      questions:
        - name: "Test Question"
          answers:
            type: "invalid_type"
            comment_allowed: false
YAML;

        (new ValidateTemplateStructure($yaml))->execute();
    }

    #[Test]
    public function it_fails_if_choice_options_are_missing(): void
    {
        $this->expectException(InvalidTemplateStructureException::class);
        $this->expectExceptionMessage("Choice answer for question 'Test Question' must specify options array");

        $yaml = <<<YAML
template:
  name: "Daily Reflection"
  columns:
    - name: "General Overview"
      questions:
        - name: "Test Question"
          answers:
            type: "choice"
            comment_allowed: false
YAML;

        (new ValidateTemplateStructure($yaml))->execute();
    }

    #[Test]
    public function it_fails_if_range_values_are_invalid(): void
    {
        $this->expectException(InvalidTemplateStructureException::class);
        $this->expectExceptionMessage("Range answer for question 'Test Question' must specify range array with exactly 2 values");

        $yaml = <<<YAML
template:
  name: "Daily Reflection"
  columns:
    - name: "General Overview"
      questions:
        - name: "Test Question"
          answers:
            type: "range"
            range: [1]
            comment_allowed: false
YAML;

        (new ValidateTemplateStructure($yaml))->execute();
    }

    #[Test]
    public function it_fails_if_range_start_is_greater_than_end(): void
    {
        $this->expectException(InvalidTemplateStructureException::class);
        $this->expectExceptionMessage("Range start must be less than range end for question 'Test Question'");

        $yaml = <<<YAML
template:
  name: "Daily Reflection"
  columns:
    - name: "General Overview"
      questions:
        - name: "Test Question"
          answers:
            type: "range"
            range: [5, 1]
            comment_allowed: false
YAML;

        (new ValidateTemplateStructure($yaml))->execute();
    }

    #[Test]
    public function it_fails_if_comment_allowed_is_missing(): void
    {
        $this->expectException(InvalidTemplateStructureException::class);
        $this->expectExceptionMessage("Answer configuration for question 'Test Question' must specify comment_allowed as boolean");

        $yaml = <<<YAML
template:
  name: "Daily Reflection"
  columns:
    - name: "General Overview"
      questions:
        - name: "Test Question"
          answers:
            type: "textarea"
YAML;

        (new ValidateTemplateStructure($yaml))->execute();
    }
}
