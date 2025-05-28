<?php

namespace App\Core;

interface RuleInterface
{
    public function evaluate(array $input): bool;

    /**
     * @return array{
     *   result: bool,
     *   details: array<string, mixed>
     * }
     */
    public function evaluateWithReport(array $input): array;
}