<?php

namespace App\Rules;

use App\Core\RuleInterface;

readonly class OrRule implements RuleInterface
{
    /**
     * @param RuleInterface[] $rules
     */
    public function __construct(private readonly array $rules)
    {
    }

    public function evaluate(array $input): bool
    {
        return array_any($this->rules, fn($rule) => $rule->evaluate($input));
    }
}