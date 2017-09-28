<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Parser;

use ExtendsFramework\Console\Definition\DefinitionException;
use ExtendsFramework\Console\Definition\DefinitionInterface;
use ExtendsFramework\Container\ContainerInterface;

interface ParserInterface
{
    /**
     * Parse $arguments against command $definition.
     *
     * When parsing fails, an exception will be thrown.
     *
     * @param DefinitionInterface $definition
     * @param array               $arguments
     * @return ContainerInterface
     * @throws ParserException
     * @throws DefinitionException
     */
    public function parse(DefinitionInterface $definition, array $arguments): ContainerInterface;
}
