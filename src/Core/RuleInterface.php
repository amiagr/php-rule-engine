<?php

namespace App\Core;

interface RuleInterface
{
    public function evaluate(array $input): bool;
}