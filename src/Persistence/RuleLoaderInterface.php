<?php

namespace App\Persistence;

interface RuleLoaderInterface
{
    public function supports(string $source): bool;

    public function load(string $source): array;
}