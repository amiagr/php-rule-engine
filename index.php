<?php

require __DIR__ . '/vendor/autoload.php';

use App\Core\RuleEngine;

$engine = new RuleEngine(['debug' => true, 'persist' => 'file', 'file' => ['path' => 'test_file.json']]);

//$rule = $engine->defineRule([
//    'type' => 'and',
//    'rules' => [
//        [
//            'type' => 'field',
//            'field' => 'order.total',
//            'operator' => '>',
//            'value' => 100000,
//        ],
//        [
//            'type' => 'not',
//            'rule' => [
//                'type' => 'field',
//                'field' => 'user.role',
//                'operator' => '==',
//                'value' => 'admin',
//            ]
//        ]
//    ]
//]);

//$ruleSet = $engine->defineRuleSet([
//    'Hamid rule' => [
//        [
//            'type' => 'field',
//            'field' => 'order.total',
//            'operator' => '>',
//            'value' => 100000,
//        ],
//        [
//            'type' => 'not',
//            'rule' => [
//                'type' => 'field',
//                'field' => 'user.role',
//                'operator' => '==',
//                'value' => 'admin',
//            ]
//        ]
//    ]
//]);

// load rules from a file or database
//$rules = $engine->loadFromFile('file.json');
//$rules = $engine->loadFromDB('TABLE_NAME');
//
// Example of evaluating a rule
//$rules->evaluate([
//    'user' => [
//        'name' => 'John Doe',
//        'age' => 20
//    ]
//]);