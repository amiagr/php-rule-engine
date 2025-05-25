<?php

namespace App\Rules;

use App\Core\RuleInterface;

class FieldComparisonRule implements RuleInterface
{
    public function __construct(
        private readonly string $field,
        private readonly string $operator,
        private readonly mixed  $value
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
}