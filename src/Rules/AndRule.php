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

    public function evaluateWithReport(array $input): array
    {
        $subReports = [];
        foreach ($this->rules as $rule) {
            $report = $rule->evaluateWithReport($input);
            $subReports[] = $report;
            if (!$report['result']) {
                return [
                    'result' => false,
                    'details' => [
                        'type' => 'and',
                        'sub_results' => $subReports,
                    ]
                ];
            }
        }
        return [
            'result' => true,
            'details' => [
                'type' => 'and',
                'sub_results' => $subReports,
            ]
        ];
    }
}