<?php

namespace App\Persistence;

use Symfony\Component\Yaml\Yaml;

class YamlRuleLoader implements RuleLoaderInterface
{
    public function supports(string $source): bool
    {
        return str_ends_with($source, '.yaml') || str_ends_with($source, '.yml');
    }

    public function load(string $source): array
    {
        if (!file_exists($source)) {
        file_put_contents($source, Yaml::dump([]));
            return [];
        }
        return Yaml::parseFile($source);
    }
}