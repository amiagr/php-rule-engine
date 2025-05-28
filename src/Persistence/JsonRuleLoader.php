<?php

namespace App\Persistence;

use InvalidArgumentException;

class JsonRuleLoader implements RuleLoaderInterface
{
    public function supports(string $source): bool
    {
        return str_ends_with($source, '.json');
    }

    public function load(string $source): array
    {
        if (!file_exists($source)) {
//            throw new InvalidArgumentException("File not found: $source");
            file_put_contents($source, json_encode([], JSON_PRETTY_PRINT));
            return [];
        }

        $json = file_get_contents($source);
        return json_decode($json, true);
    }
}