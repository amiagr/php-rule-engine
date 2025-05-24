<?php

 use PHPUnit\Framework\TestCase;
 use App\Core\Engine;

    class EngineTest extends TestCase
    {
        public function testRun(): void
        {
//            $engine = new Engine();
//            $this->expectNotToPerformAssertions();
//            $engine->run([]);

            $engine = new Engine();

            // Capture output
            ob_start();
            $engine->run([
                'user' => ['type' => 'VIP'],
                'order' => ['total' => 600000],
            ]);
            $output = ob_get_clean();

            // Assert that the output contains expected text
            $this->assertStringContainsString("Running rule engine on:", $output);
            $this->assertStringContainsString("user", $output);
            $this->assertStringContainsString("order", $output);
        }
    }