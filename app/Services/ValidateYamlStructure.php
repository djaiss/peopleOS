<?php

declare(strict_types=1);

namespace App\Services;

use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class ValidateYamlStructure
{
    private const array ALLOWED_TYPES = ['choice', 'range', 'textarea'];

    private const int MAX_COLUMNS = 3;

    public function __construct(
        private readonly string $yamlContent,
    ) {}

    public function execute(): array
    {
        try {
            $data = Yaml::parse($this->yamlContent);
        } catch (ParseException) {
            return ['valid' => false, 'error' => 'Invalid YAML format'];
        }

        if (! isset($data['template'])) {
            return ['valid' => false, 'error' => 'Missing template root element'];
        }

        $template = $data['template'];

        if (! isset($template['name'])) {
            return ['valid' => false, 'error' => 'Template name is required'];
        }

        if (! isset($template['columns']) || ! is_array($template['columns'])) {
            return ['valid' => false, 'error' => 'Columns are required and must be an array'];
        }

        if (count($template['columns']) > self::MAX_COLUMNS) {
            return ['valid' => false, 'error' => 'Maximum 3 columns allowed'];
        }

        foreach ($template['columns'] as $index => $column) {
            $columnValidation = $this->validateColumn($column, $index + 1);
            if (! $columnValidation['valid']) {
                return $columnValidation;
            }
        }

        return ['valid' => true];
    }

    private function validateColumn(array $column, int $columnNumber): array
    {
        if (! isset($column['name'])) {
            return ['valid' => false, 'error' => "Column {$columnNumber} missing name"];
        }

        if (! isset($column['questions']) || ! is_array($column['questions']) || empty($column['questions'])) {
            return ['valid' => false, 'error' => "Column {$columnNumber} must have at least one question"];
        }

        foreach ($column['questions'] as $index => $question) {
            $questionValidation = $this->validateQuestion($question, $columnNumber, $index + 1);
            if (! $questionValidation['valid']) {
                return $questionValidation;
            }
        }

        return ['valid' => true];
    }

    private function validateQuestion(array $question, int $columnNumber, int $questionNumber): array
    {
        if (! isset($question['name'])) {
            return ['valid' => false, 'error' => "Question {$questionNumber} in column {$columnNumber} missing name"];
        }

        if (! isset($question['answers']) || ! isset($question['answers']['type'])) {
            return ['valid' => false, 'error' => "Question {$questionNumber} in column {$columnNumber} missing answer type"];
        }

        $type = $question['answers']['type'];
        if (! in_array($type, self::ALLOWED_TYPES)) {
            return ['valid' => false, 'error' => "Invalid answer type '{$type}' in column {$columnNumber}, question {$questionNumber}"];
        }

        if ($type === 'choice' && (! isset($question['answers']['options']) || ! is_array($question['answers']['options']))) {
            return ['valid' => false, 'error' => "Choice type requires options array in column {$columnNumber}, question {$questionNumber}"];
        }

        if ($type === 'range' && (! isset($question['answers']['range']) || ! is_array($question['answers']['range']) || count($question['answers']['range']) !== 2)) {
            return ['valid' => false, 'error' => "Range type requires valid range array [min, max] in column {$columnNumber}, question {$questionNumber}"];
        }

        return ['valid' => true];
    }
}
