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
     * When $strict mode is disabled, only operands and options that can be matched will be returned. No exception
     * will be thrown.
     *
     * @param DefinitionInterface $definition
     * @param array               $arguments
     * @param bool|null           $strict
     * @return ContainerInterface
     * @throws ParserException
     * @throws DefinitionException
     */
    public function parse(DefinitionInterface $definition, array $arguments, bool $strict = null): ContainerInterface;
}
