<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Arguments\Parser;

use ExtendsFramework\Console\Arguments\ArgumentsInterface;
use ExtendsFramework\Console\Arguments\Definition\DefinitionException;
use ExtendsFramework\Console\Arguments\Definition\DefinitionInterface;
use ExtendsFramework\Container\ContainerInterface;

interface ParserInterface
{
    /**
     * Parse $arguments against command $definition.
     *
     * When parsing fails, an exception will be thrown.
     *
     * @param DefinitionInterface $definition
     * @param ArgumentsInterface  $arguments
     * @return ContainerInterface
     * @throws ParserException
     * @throws DefinitionException
     */
    public function parse(DefinitionInterface $definition, ArgumentsInterface $arguments): ContainerInterface;
}
