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

    public function evaluateWithReport(array $input): array
    {
        $subReports = [];
        foreach ($this->rules as $rule) {
            $report = $rule->evaluateWithReport($input);
            $subReports[] = $report;
            if ($report['result']) {
                return [
                    'result' => true,
                    'details' => [
                        'type' => 'or',
                        'sub_results' => $subReports,
                    ]
                ];
            }
        }

        return [
            'result' => false,
            'details' => [
                'type' => 'or',
                'sub_results' => $subReports,
            ]
        ];
    }
}