<?php

namespace App\Core;

use App\Evaluators\RuleEvaluator;
use App\Validation\RuleDefinitionValidator;
use InvalidArgumentException;

class RuleSet
{
    private RuleEvaluator $evaluator;

    /**
     * RuleSet constructor.
     *
     * @param array $definitions
     * @throws InvalidArgumentException
     */
    public function __construct(private array $definitions)
    {
        $this->evaluator = new RuleEvaluator();

        foreach ($this->definitions as $name => $definition) {
            $this->add($definition, $name);
        }
    }

    /**
     * Add a new rule definition.
     *
     * @param array $definition
     * @param string|null $name
     * @return string
     */
    public function add(array $definition, ?string $name = null): string
    {
        foreach ($definition as $key => $rule) {
            // ToDo:: replace with RuleDefinitionValidator
            // RuleDefinitionValidator::validate($definition);
            $this->validate($rule, $name);
        }

        if (!$name) {
            $name = $this->generateName($definition);
        }

        $this->definitions[$name] = $definition;

        return $name;
    }

    public function update(string $name, array $newDefinition): void
    {
        if (!isset($this->definitions[$name])) {
            throw new InvalidArgumentException("Rule '{$name}' not found.");
        }


        foreach ($newDefinition as $key => $rule) {
            // ToDo:: replace with RuleDefinitionValidator
            // RuleDefinitionValidator::validate($definition);
            $this->validate($rule, $name);
        }
        $this->definitions[$name] = $newDefinition;
    }

    public function delete(string $name): void
    {
        unset($this->definitions[$name]);
    }

    /**
     * @param string $name
     * @param array $input
     * @return array
     */
    public function evaluate(string $name, array $input): array
    {
        if (!isset($this->definitions[$name])) {
            throw new InvalidArgumentException("RuleSet '{$name}' not found.");
        }

        $ruleDefinition = $this->definitions[$name];

        $rule = RuleFactory::fromArray($ruleDefinition);

        return $this->evaluator->evaluate($rule, $input);
    }

    /**
     * Get the definition of a specific rule set.
     *
     * @param string $name
     * @return array
     * @throws InvalidArgumentException if the rule set does not exist.
     */
    public function get(string $name): array
    {
        if (!isset($this->definitions[$name])) {
            throw new InvalidArgumentException("RuleSet '{$name}' not found.");
        }
        return $this->definitions[$name];
    }

    public function all(): array
    {
        return $this->definitions;
    }

    public function has(string $name): bool
    {
        return isset($this->definitions[$name]);
    }

    private function validate(array $definition, string $name): void
    {
        if (!isset($definition['type']) || !in_array($definition['type'], ['and', 'or', 'not', 'field'])) {
            throw new InvalidArgumentException("RuleSet definition for '{$name}' must have a valid 'type' key.");
        }

        if ($definition['type'] === 'field') {
            if (!isset($definition['field'], $definition['operator'], $definition['value'])) {
                throw new InvalidArgumentException("Field rule must have 'field', 'operator', and 'value' keys.");
            }
        }

        if (in_array($definition['type'], ['and', 'or'])) {
            if (!isset($definition['rules']) || !is_array($definition['rules'])) {
                throw new InvalidArgumentException("Rule of type '{$definition['type']}' must have a 'rules' key with an array value.");
            }
        }

        if ($definition['type'] === 'not') {
            if (!isset($definition['rule']) || !is_array($definition['rule'])) {
                throw new InvalidArgumentException("Rule of type 'not' must have a 'rule' key with an array value.");
            }
        }
    }

    private function generateName(array $definition): string
    {
        return substr(sha1(json_encode($definition)), 0, 8);
    }
}
