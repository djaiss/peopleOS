<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;
use App\Exceptions\InvalidTemplateStructureException;

class ValidateTemplateStructure
{
    private array $parsedYaml;

    private array $allowedAnswerTypes = ['choice', 'range', 'textarea'];

    public function __construct(
        public string $yamlContent
    ) {}

    public function execute(): bool
    {
        $this->parseYaml();
        $this->validateMainStructure();
        $this->validateColumns();

        return true;
    }

    private function parseYaml(): void
    {
        try {
            $this->parsedYaml = Yaml::parse($this->yamlContent);
        } catch (ParseException $e) {
            throw new InvalidTemplateStructureException('Invalid YAML format: ' . $e->getMessage());
        }
    }

    private function validateMainStructure(): void
    {
        if (!isset($this->parsedYaml['template'])) {
            throw new InvalidTemplateStructureException('Missing template root element');
        }

        if (!isset($this->parsedYaml['template']['name'])) {
            throw new InvalidTemplateStructureException('Template name is required');
        }

        if (!isset($this->parsedYaml['template']['columns']) || !is_array($this->parsedYaml['template']['columns'])) {
            throw new InvalidTemplateStructureException('Template must contain columns array');
        }
    }

    private function validateColumns(): void
    {
        foreach ($this->parsedYaml['template']['columns'] as $columnIndex => $column) {
            $this->validateColumn($column, $columnIndex);
        }
    }

    private function validateColumn(array $column, int $columnIndex): void
    {
        if (!isset($column['name'])) {
            throw new InvalidTemplateStructureException("Column at index {$columnIndex} must have a name");
        }

        if (!isset($column['questions']) || !is_array($column['questions'])) {
            throw new InvalidTemplateStructureException("Column '{$column['name']}' must contain questions array");
        }

        foreach ($column['questions'] as $questionIndex => $question) {
            $this->validateQuestion($question, $column['name'], $questionIndex);
        }
    }

    private function validateQuestion(array $question, string $columnName, int $questionIndex): void
    {
        if (!isset($question['name'])) {
            throw new InvalidTemplateStructureException("Question at index {$questionIndex} in column '{$columnName}' must have a name");
        }

        if (!isset($question['answers']) || !is_array($question['answers'])) {
            throw new InvalidTemplateStructureException("Question '{$question['name']}' must have answers configuration");
        }

        $this->validateAnswers($question['answers'], $question['name']);
    }

    private function validateAnswers(array $answers, string $questionName): void
    {
        if (!isset($answers['type'])) {
            throw new InvalidTemplateStructureException("Answer configuration for question '{$questionName}' must specify a type");
        }

        if (!in_array($answers['type'], $this->allowedAnswerTypes)) {
            throw new InvalidTemplateStructureException("Invalid answer type '{$answers['type']}' for question '{$questionName}'");
        }

        if (!isset($answers['comment_allowed']) || !is_bool($answers['comment_allowed'])) {
            throw new InvalidTemplateStructureException("Answer configuration for question '{$questionName}' must specify comment_allowed as boolean");
        }

        // Validate specific answer types
        switch ($answers['type']) {
            case 'choice':
                $this->validateChoiceAnswer($answers, $questionName);
                break;
            case 'range':
                $this->validateRangeAnswer($answers, $questionName);
                break;
        }
    }

    private function validateChoiceAnswer(array $answers, string $questionName): void
    {
        if (!isset($answers['options']) || !is_array($answers['options']) || empty($answers['options'])) {
            throw new InvalidTemplateStructureException("Choice answer for question '{$questionName}' must specify options array");
        }
    }

    private function validateRangeAnswer(array $answers, string $questionName): void
    {
        if (!isset($answers['range']) || !is_array($answers['range']) || count($answers['range']) !== 2) {
            throw new InvalidTemplateStructureException("Range answer for question '{$questionName}' must specify range array with exactly 2 values");
        }

        if (!is_numeric($answers['range'][0]) || !is_numeric($answers['range'][1])) {
            throw new InvalidTemplateStructureException("Range values for question '{$questionName}' must be numeric");
        }

        if ($answers['range'][0] >= $answers['range'][1]) {
            throw new InvalidTemplateStructureException("Range start must be less than range end for question '{$questionName}'");
        }
    }
}
