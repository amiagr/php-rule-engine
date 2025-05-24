<?php

namespace App\Core;

class Engine
{
    public function run(array $input): void
    {
        echo "Running rule engine on:\n";
        print_r($input);
        // Here you would typically process the input through your rules engine
    }
}
