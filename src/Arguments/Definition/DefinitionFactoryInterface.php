<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Arguments\Definition;

interface DefinitionFactoryInterface
{
    /**
     * Create new DefinitionInterface from $config.
     *
     * @param array $config
     * @return DefinitionInterface
     * @throws DefinitionException
     */
    public function create(array $config): DefinitionInterface;
}
