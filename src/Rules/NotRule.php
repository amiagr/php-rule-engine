<?php

namespace App\Rules;

use App\Core\RuleInterface;

readonly class NotRule implements RuleInterface
{
    /**
     * @param RuleInterface $rule
     */
    public function __construct(private RuleInterface $rule)
    {
    }

    public function evaluate(array $input): bool
    {
        return !($this->rule->evaluate($input));
    }
}