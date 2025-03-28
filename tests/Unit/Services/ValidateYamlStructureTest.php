<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Services\ValidateYamlStructure;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ValidateYamlStructureTest extends TestCase
{
    private string $validYaml;

    #[Test]
    public function it_validates_valid_yaml_structure(): void
    {
        $this->validYaml = <<<'YAML'
template:
  name: "Daily Reflection"
  columns:
    - name: "Morning"
      questions:
        - name: "Sleep quality"
          answers:
            type: "range"
            range: [1, 5]
            comment_allowed: true
    - name: "Afternoon"
      questions:
        - name: "Productivity"
          answers:
            type: "choice"
            options: ["High", "Medium", "Low"]
            comment_allowed: false
YAML;
        $result = (new ValidateYamlStructure($this->validYaml))->execute();
        $this->assertTrue($result['valid']);
    }

    #[Test]
    public function it_fails_on_invalid_yaml_syntax(): void
    {
        $invalidYaml = <<<'YAML'
template:
  name: "Invalid
    syntax:
YAML;

        $result = (new ValidateYamlStructure($invalidYaml))->execute();
        $this->assertFalse($result['valid']);
        $this->assertEquals('Invalid YAML format', $result['error']);
    }

    #[Test]
    public function it_fails_without_template_root(): void
    {
        $yaml = 'name: "Test"';
        $result = (new ValidateYamlStructure($yaml))->execute();

        $this->assertFalse($result['valid']);
        $this->assertEquals('Missing template root element', $result['error']);
    }

    #[Test]
    public function it_fails_without_template_name(): void
    {
        $yaml = <<<'YAML'
template:
  columns: []
YAML;

        $result = (new ValidateYamlStructure($yaml))->execute();
        $this->assertFalse($result['valid']);
        $this->assertEquals('Template name is required', $result['error']);
    }

    #[Test]
    public function it_fails_with_more_than_three_columns(): void
    {
        $yaml = <<<'YAML'
template:
  name: "Too Many Columns"
  columns:
    - name: "Column 1"
      questions:
        - name: "Question 1"
          answers:
            type: "textarea"
    - name: "Column 2"
      questions:
        - name: "Question 1"
          answers:
            type: "textarea"
    - name: "Column 3"
      questions:
        - name: "Question 1"
          answers:
            type: "textarea"
    - name: "Column 4"
      questions:
        - name: "Question 1"
          answers:
            type: "textarea"
YAML;

        $result = (new ValidateYamlStructure($yaml))->execute();
        $this->assertFalse($result['valid']);
        $this->assertEquals('Maximum 3 columns allowed', $result['error']);
    }

    #[Test]
    public function it_fails_with_unnamed_column(): void
    {
        $yaml = <<<'YAML'
template:
  name: "Missing Column Name"
  columns:
    - questions:
        - name: "Question 1"
          answers:
            type: "textarea"
YAML;

        $result = (new ValidateYamlStructure($yaml))->execute();
        $this->assertFalse($result['valid']);
        $this->assertEquals('Column 1 missing name', $result['error']);
    }

    #[Test]
    public function it_fails_with_empty_column(): void
    {
        $yaml = <<<'YAML'
template:
  name: "Empty Column"
  columns:
    - name: "Empty Column"
      questions: []
YAML;

        $result = (new ValidateYamlStructure($yaml))->execute();
        $this->assertFalse($result['valid']);
        $this->assertEquals('Column 1 must have at least one question', $result['error']);
    }

    #[Test]
    public function it_fails_with_invalid_question_type(): void
    {
        $yaml = <<<'YAML'
template:
  name: "Invalid Type"
  columns:
    - name: "Column 1"
      questions:
        - name: "Question 1"
          answers:
            type: "invalid_type"
YAML;

        $result = (new ValidateYamlStructure($yaml))->execute();
        $this->assertFalse($result['valid']);
        $this->assertEquals("Invalid answer type 'invalid_type' in column 1, question 1", $result['error']);
    }

    #[Test]
    public function it_fails_when_choice_type_missing_options(): void
    {
        $yaml = <<<'YAML'
template:
  name: "Missing Options"
  columns:
    - name: "Column 1"
      questions:
        - name: "Question 1"
          answers:
            type: "choice"
YAML;

        $result = (new ValidateYamlStructure($yaml))->execute();
        $this->assertFalse($result['valid']);
        $this->assertEquals('Choice type requires options array in column 1, question 1', $result['error']);
    }

    #[Test]
    public function it_fails_when_range_type_missing_range(): void
    {
        $yaml = <<<'YAML'
template:
  name: "Missing Range"
  columns:
    - name: "Column 1"
      questions:
        - name: "Question 1"
          answers:
            type: "range"
YAML;

        $result = (new ValidateYamlStructure($yaml))->execute();
        $this->assertFalse($result['valid']);
        $this->assertEquals('Range type requires valid range array [min, max] in column 1, question 1', $result['error']);
    }

    #[Test]
    public function it_fails_when_range_type_has_invalid_range_format(): void
    {
        $yaml = <<<'YAML'
template:
  name: "Invalid Range"
  columns:
    - name: "Column 1"
      questions:
        - name: "Question 1"
          answers:
            type: "range"
            range: [1]
YAML;

        $result = (new ValidateYamlStructure($yaml))->execute();
        $this->assertFalse($result['valid']);
        $this->assertEquals('Range type requires valid range array [min, max] in column 1, question 1', $result['error']);
    }
}
