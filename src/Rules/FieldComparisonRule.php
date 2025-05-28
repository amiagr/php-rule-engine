<?php

namespace App\Rules;

use App\Core\RuleInterface;

readonly class FieldComparisonRule implements RuleInterface
{
    public function __construct(
        private string $field,
        private string $operator,
        private mixed  $value
    )
    {
    }

    public function evaluate(array $input): bool
    {
        $parts = explode('.', $this->field);
        $current = $input;

        foreach ($parts as $part) {
            if (!isset($current[$part])) {
                return false;
            }
            $current = $current[$part];
        }

        $requiresNumeric = in_array($this->operator, ['>', '<', '>=', '<=']);

        if ($requiresNumeric && (!is_numeric($current) || !is_numeric($this->value))) {
            return false;
        }

        return match ($this->operator) {
            '>' => $current > $this->value,
            '<' => $current < $this->value,
            '>=' => $current >= $this->value,
            '<=' => $current <= $this->value,
            '==' => $current == $this->value,
            '!=' => $current != $this->value,
            default => false,
        };
    }

    public function evaluateWithReport(array $input): array
    {
        $result = $this->evaluate($input);

        $details = [
            'type' => 'field_comparison',
            'field' => $this->field,
            'operator' => $this->operator,
            'value' => $this->value,
            'input_value' => $this->getFieldValue($input, $this->field),
        ];

        return ['result' => $result, 'details' => $details];
    }

    private function getFieldValue(array $input, string $field): mixed
    {
        $parts = explode('.', $field);
        $current = $input;
        foreach ($parts as $part) {
            if (!isset($current[$part])) {
                return null;
            }
            $current = $current[$part];
        }
        return $current;
    }
}