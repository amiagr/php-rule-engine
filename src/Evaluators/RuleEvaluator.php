<?php

namespace App\Evaluators;

use App\Core\RuleInterface;

readonly class RuleEvaluator
{
    /**
     * @param RuleInterface $rule
     * @param array $input
     * @param array $options
     * @return array|bool ['result' => bool, 'details' => array]
     */
    public function evaluate(RuleInterface $rule, array $input, array $options = []): array|bool
    {
        $debug = $options['debug'] ?? false;

        if ($debug) {
            $result = $rule->evaluateWithReport($input);
        } else {
            $result = $rule->evaluate($input);
        }

        return $result;
    }
}
