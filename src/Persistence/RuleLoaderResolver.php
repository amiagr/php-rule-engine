<?php

namespace App\Persistence;

use InvalidArgumentException;

readonly class RuleLoaderResolver
{
    /**
     * @param RuleLoaderInterface[] $loaders
     */
    public function __construct(private array $loaders)
    {
    }
    /**
     * Resolve a loader for the given source.
     *
     * @param string $source
     * @return RuleLoaderInterface
     * @throws InvalidArgumentException
     */
    private function resolve(string $source): RuleLoaderInterface
    {
        foreach ($this->loaders as $loader) {
            if ($loader->supports($source)) {
                return $loader;
            }
        }
        throw new InvalidArgumentException("No loader found for source: $source");
    }

    public function load(string $source): array
    {
        $loader = $this->resolve($source);
        return $loader->load($source);
    }
}