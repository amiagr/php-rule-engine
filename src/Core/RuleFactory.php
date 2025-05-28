<?php

namespace App\Core;

use App\Rules\AndRule;
use App\Rules\FieldComparisonRule;
use App\Rules\NotRule;
use App\Rules\OrRule;
use App\Validation\RuleDefinitionValidator;
use InvalidArgumentException;

class RuleFactory
{
    public static function fromArray(array $definition): RuleInterface
    {
        RuleDefinitionValidator::validate($definition);

        $type = $definition['type'] ?? null;
        return match ($type) {
            'field' => self::makeFieldComparison($definition),
            'and'   => new AndRule(self::mapRules($definition, 'rules')),
            'or'    => new OrRule(self::mapRules($definition, 'rules')),
            'not'   => new NotRule(self::fromArray($definition['rule'] ?? [])),
            default => throw new InvalidArgumentException("Invalid or missing rule type."),
        };
    }

    private static function makeFieldComparison(array $definition): RuleInterface
    {
        foreach (['field', 'operator', 'value'] as $key) {
            if (!array_key_exists($key, $definition)) {
                throw new InvalidArgumentException("Missing '$key' in field comparison rule.");
            }
        }

        return new FieldComparisonRule(
            $definition['field'],
            $definition['operator'],
            $definition['value']
        );
    }

    private static function mapRules(array $definition, string $key): array
    {
        if (!isset($definition[$key]) || !is_array($definition[$key])) {
            throw new InvalidArgumentException("Missing or invalid '$key' for rule group.");
        }

        return array_map([self::class, 'fromArray'], $definition[$key]);
    }
}
