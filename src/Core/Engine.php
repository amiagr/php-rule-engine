<?php

namespace App\Core;

use App\Rules\AndRule;
use App\Rules\FieldComparisonRule;
use App\Rules\FieldEqualsRule;
use App\Core\RuleFactory;

class Engine
{
    public function run(array $input): void
    {
        echo "Running rule engine:\n";
//        print_r($input);
        // Here you would typically process the input through your rules engine
//        $rules = [
//            new FieldEqualsRule('user.type', 'VIP'),
//            new FieldEqualsRule('order.total', 600000),
//            new FieldComparisonRule('order.total', '>', 500000),
//        ];
//
//        foreach ($rules as $rule) {
//            $result = $rule->evaluate($input);
//            echo get_class($rule) . ': ' . ($result ? '✔' : '✖') . PHP_EOL;
//        }
//        $rule = new AndRule([
//            new FieldComparisonRule('user.age', '>', 18),
//            new FieldComparisonRule('user.country', '<', 'CA'),
//        ]);
//
//        $data = [
//            'user' => [
//                'age' => 25,
//                'country' => 'CA',
//            ],
//        ];

//        var_dump($rule->evaluate($data));

        $definition = [
            'type' => 'and',
            'rules' => [
                [
                    'type' => 'field',
                    'field' => 'user.age',
                    'operator' => '>=',
                    'value' => 18,
                ],
                [
                    'type' => 'not',
                    'rule' => [
                        'type' => 'field',
                        'field' => 'user.banned',
                        'operator' => '==',
                        'value' => true,
                    ]
                ],
            ]
        ];

        $rule = RuleFactory::fromArray($definition);
        $result = $rule->evaluate([
            'user' => [
                'age' => 20,
                'banned' => false,
            ]
        ]);
        var_dump($rule);
        var_dump($result);
    }
}
