<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Arguments\Parser\Posix;

use ExtendsFramework\Console\Arguments\ArgumentsInterface;
use ExtendsFramework\Console\Arguments\Definition\DefinitionException;
use ExtendsFramework\Console\Arguments\Definition\DefinitionInterface;
use ExtendsFramework\Console\Arguments\Parser\ParserException;
use ExtendsFramework\Console\Arguments\Parser\ParserInterface;
use ExtendsFramework\Console\Arguments\Parser\Posix\Exception\ArgumentNotAllowed;
use ExtendsFramework\Console\Arguments\Parser\Posix\Exception\MissingArgument;
use ExtendsFramework\Console\Arguments\Parser\Posix\Exception\MissingOperand;
use ExtendsFramework\Container\Container;
use ExtendsFramework\Container\ContainerInterface;

class PosixParser implements ParserInterface
{
    /**
     * @inheritDoc
     */
    public function parse(DefinitionInterface $definition, ArgumentsInterface $arguments): ContainerInterface
    {
        $parsed = new Container(
            $this->parseArguments($definition, $arguments)
        );

        foreach ($definition->getOperands() as $operand) {
            $name = $operand->getName();
            if ($parsed->has($name) === false) {
                throw new MissingOperand($name);
            }
        }

        return $parsed;
    }

    /**
     * Parse $arguments against $definition.
     *
     * @param DefinitionInterface $definition
     * @param ArgumentsInterface  $arguments
     * @return array
     * @throws ParserException|DefinitionException
     */
    protected function parseArguments(DefinitionInterface $definition, ArgumentsInterface $arguments): array
    {
        $operandPosition = 0;
        $terminated = false;
        $parsed = [];

        foreach ($arguments as $argument) {
            $argument = trim($argument);

            if ($terminated) {
                $operand = $definition->getOperand($operandPosition++);
                $parsed[$operand->getName()] = $argument;
            } elseif ($argument === '--') {
                $terminated = true;
            } elseif (strpos($argument, '--') === 0) {
                $argument = substr($argument, 2);
                $argument = explode('=', $argument, 2);
                $hasArgument = isset($argument[1]);

                $option = $definition->getOption($argument[0], true);
                $name = $option->getName();
                if ($option->isFlag()) {
                    if ($hasArgument) {
                        throw new ArgumentNotAllowed($option, true);
                    }

                    if ($option->isMultiple()) {
                        $parsed[$name] = ($parsed[$name] ?? 0) + 1;
                    } else {
                        $parsed[$name] = true;
                    }
                } elseif ($hasArgument) {
                    $parsed[$name] = $argument[1];
                } else {
                    $arguments->next();
                    if ($arguments->valid()) {
                        $parsed[$name] = $arguments->current();
                    } elseif ($option->isRequired()) {
                        throw new MissingArgument($option, true);
                    }
                }
            } elseif (strpos($argument, '-') === 0) {
                $argument = substr($argument, 1);

                $parts = str_split($argument);
                foreach ($parts as $index => $part) {
                    $option = $definition->getOption($part);
                    $name = $option->getName();

                    if ($option->isFlag()) {
                        if ($option->isMultiple()) {
                            $parsed[$name] = ($parsed[$name] ?? 0) + 1;
                        } else {
                            $parsed[$name] = true;
                        }
                    } elseif (count($parts) > ($index + 1)) {
                        $value = implode(array_slice($parts, $index + 1));
                        if (strpos($value, '=') === 0) {
                            $value = substr($value, 1);
                        }

                        $parsed[$name] = $value;

                        break;
                    } else {
                        $arguments->next();
                        if ($arguments->valid()) {
                            $parsed[$name] = $arguments->current();
                        } elseif ($option->isRequired()) {
                            throw new MissingArgument($option);
                        }
                    }
                }
            } else {
                $operand = $definition->getOperand($operandPosition++);
                $parsed[$operand->getName()] = $argument;
            }
        }

        return $parsed;
    }
}
