<?php

namespace App\Rules;

use App\Core\RuleInterface;

class FieldEqualsRule implements RuleInterface
{
    public function __construct(
        private readonly string $field,
        private readonly mixed  $value
    ) {}

    public function evaluate(array $input): bool
    {
        $parts = explode('.', $this->field);
        $current = $input;

        foreach ($parts as $part) {
            if (!isset($current[$part])) {
                return false;
            }
            $current = $current[$part];
        }

        return $current === $this->value;
    }

    public function evaluateWithReport(array $input): array
    {
        $result = $this->evaluate($input);
        $details = [
            'type' => 'field_comparison',
            'field' => $this->field,
            'value' => $this->value,
            'input_value' => $this->getFieldValue($input, $this->field),
        ];

        return ['result' => $result, 'details' => ['type' => 'equal', 'original' => $details]];
    }
    /**
     * Retrieves the value of a nested field in the input array.
     *
     * @param array $input The input data.
     * @param string $field The field path, e.g., 'user.name'.
     * @return mixed|null The value of the field or null if not found.
     */
    private function getFieldValue(array $input, string $field): mixed
    {
        $parts = explode('.', $field);
        $current = $input;
        foreach ($parts as $part) {
            if (!isset($current[$part])) {
                return null;
            }
            $current = $current[$part];
        }
        return $current;
    }
}