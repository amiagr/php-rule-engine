<?php

namespace App\Rules;

use App\Core\RuleInterface;

readonly class AndRule implements RuleInterface
{
    /**
     * @param RuleInterface[] $rules
     */
    public function __construct(private array $rules)
    {
    }

    public function evaluate(array $input): bool
    {
        return array_all($this->rules, fn($rule) => $rule->evaluate($input));
    }
}