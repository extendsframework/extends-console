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
     * When $strict mode is disabled, only operands and options that can be matched will be returned, no exception
     * will be thrown. Arguments that can not be parsed will be added to $remaining for later usage.
     *
     * @param DefinitionInterface $definition
     * @param array               $arguments
     * @param bool|null           $strict
     * @param array|null          $remaining
     * @return ContainerInterface
     * @throws ParserException
     * @throws DefinitionException
     */
    public function parse(DefinitionInterface $definition, array $arguments, bool $strict = null, array &$remaining = null): ContainerInterface;
}
