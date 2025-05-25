<?php

namespace App\Core;

use App\Rules\AndRule;
use App\Rules\FieldComparisonRule;
use App\Rules\NotRule;
use App\Rules\OrRule;
use InvalidArgumentException;

class RuleFactory
{
    public static function fromArray(array $data): RuleInterface
    {
        return match ($data['type'] ?? null) {
            'field' => self::makeFieldComparison($data),
            'and'   => new AndRule(self::mapRules($data, 'rules')),
            'or'    => new OrRule(self::mapRules($data, 'rules')),
            'not'   => new NotRule(self::fromArray($data['rule'] ?? [])),
            default => throw new InvalidArgumentException("Invalid or missing rule type."),
        };
    }

    private static function makeFieldComparison(array $data): RuleInterface
    {
        foreach (['field', 'operator', 'value'] as $key) {
            if (!array_key_exists($key, $data)) {
                throw new InvalidArgumentException("Missing '$key' in field comparison rule.");
            }
        }

        return new FieldComparisonRule(
            $data['field'],
            $data['operator'],
            $data['value']
        );
    }

    private static function mapRules(array $data, string $key): array
    {
        if (!isset($data[$key]) || !is_array($data[$key])) {
            throw new InvalidArgumentException("Missing or invalid '$key' for rule group.");
        }

        return array_map([self::class, 'fromArray'], $data[$key]);
    }
}
