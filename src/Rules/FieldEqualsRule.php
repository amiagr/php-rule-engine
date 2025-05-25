<?php

namespace App\Rules;

use App\Core\RuleInterface;

class FieldEqualsRule implements RuleInterface
{
    public function __construct(
        private readonly string $field,
        private readonly mixed $value
    ) {}

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

        return $current === $this->value;
    }
}