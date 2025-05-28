<?php

namespace App\Core;

use App\Evaluators\RuleEvaluator;
use App\Persistence\JsonRuleLoader;
use App\Persistence\RuleLoaderResolver;
use App\Persistence\YamlRuleLoader;
use App\Validation\RuleDefinitionValidator;
use InvalidArgumentException;

class RuleEngine
{
    private RuleEvaluator $evaluator;
    private RuleLoaderResolver $resolver;
    private bool $debug;
    private string $source;
    private array $persist;

    public function __construct(array $options = [])
    {
        $this->evaluator = new RuleEvaluator();
        $this->resolver = new RuleLoaderResolver([
            new JsonRuleLoader(),
            new YamlRuleLoader(),
        ]);

        // Set options if needed
        if (isset($options['debug'])) {
            $this->debug = $options['debug'];
        }

        if (isset($options['persist'])) {
            $this->persist = $options[$options['persist']];
            switch ($options['persist']) {
                case 'db':
                    // Initialize DB loader
                    break;
                case 'file':
                    if (!isset($options['file']['path']) ) {
                        throw new InvalidArgumentException('File path is required for file persistence.');
                    }
                    $this->source = $options['file']['path'];
                    $this->resolver->load($options['file']['path']);
                    break;
            }
        }
    }


    public function defineRule(array $definition): RuleInterface
    {
        return RuleFactory::fromArray($definition);
    }

    public function defineRuleSet(array $definitions): RuleSet
    {
        return new RuleSet($definitions);
    }

    public function evaluate(array|string $rule, array $input): array
    {
//        $ruleInstance = RuleFactory::fromArray($rule);
//        return $this->evaluator->evaluate($ruleInstance, $input, $this->options);
//
//        // حالت دوم: rule = string → یعنی رول‌ست داریم و دنبال یه name خاصی هستیم
//        $ruleSet = $this->loadRuleSet(); // از فایل می‌خونیم و RuleSet می‌سازیم
//        return $this->evaluator->evaluate($ruleSet, $rule, $input);
    }

    private function loadRuleSet(): RuleSet
    {
//        $loader = new JsonRuleLoader($this->source);
//        $rules = $loader->load(); // returns associative array: ['some_rule' => [...], ...]
//        $ruleSet = new RuleSet();
//
//        foreach ($rules as $name => $definition) {
//            $ruleSet->add($name, RuleFactory::fromArray($definition));
//        }
//
//        return $ruleSet;
    }
}
