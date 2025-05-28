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
    /**
     * Evaluates the rule and returns a report with details.
     *
     * @param array $input The input data to evaluate against the rule.
     * @return array An associative array containing the result and details of the evaluation.
     */
    public function evaluateWithReport(array $input): array
    {
        $innerReport = $this->rule->evaluateWithReport($input);
        return [
            'result' => !$innerReport['result'],
            'details' => [
                'type' => 'not',
                'original' => $innerReport,
            ]
        ];
    }
}