<?php

if (!function_exists('array_any')) {
    function array_any(array $items, callable $callback): bool
    {
        foreach ($items as $item) {
            if ($callback($item)) {
                return true;
            }
        }
        return false;
    }
}
if (!function_exists('array_all')) {
    function array_all(array $items, callable $callback): bool
    {
        foreach ($items as $item) {
            if (!$callback($item)) {
                return false;
            }
        }
        return true;
    }
}