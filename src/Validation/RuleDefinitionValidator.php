<?php

namespace App\Validation;

use InvalidArgumentException;

class RuleDefinitionValidator
{
    /**
     * Validate definition array against expected structure.
     * Throws InvalidArgumentException on failure.
     *
     * @param array $definition
     */
    public static function validate(array $definition): void
    {
        if (!isset($definition['type']) || !is_string($definition['type'])) {
            throw new InvalidArgumentException("Rule definition must have a string 'type'.");
        }

        $type = $definition['type'];
        switch ($type) {
            case 'field':
                foreach (['field', 'operator', 'value'] as $key) {
                    if (!array_key_exists($key, $definition)) {
                        throw new InvalidArgumentException("Field rule must contain '$key'.");
                    }
                }
                break;
            case 'and':
            case 'or':
                if (empty($definition['rules']) || !is_array($definition['rules'])) {
                    throw new InvalidArgumentException("'$type' rule must contain non-empty 'rules' array.");
                }
                foreach ($definition['rules'] as $subDef) {
                    if (!is_array($subDef)) {
                        throw new InvalidArgumentException("Each sub-rule in '$type' must be an array definition.");
                    }
                    self::validate($subDef);
                }
                break;
            case 'not':
                if (empty($definition['rule']) || !is_array($definition['rule'])) {
                    throw new InvalidArgumentException("'not' rule must contain single 'rule' definition.");
                }
                self::validate($definition['rule']);
                break;
            default:
                throw new InvalidArgumentException("Unknown rule type: $type");
        }
    }
}

