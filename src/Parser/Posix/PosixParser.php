<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Parser\Posix;

use ArrayIterator;
use ExtendsFramework\Console\Definition\DefinitionException;
use ExtendsFramework\Console\Definition\DefinitionInterface;
use ExtendsFramework\Console\Definition\Operand\OperandInterface;
use ExtendsFramework\Console\Definition\Option\OptionInterface;
use ExtendsFramework\Console\Parser\ParserInterface;
use ExtendsFramework\Console\Parser\Posix\Exception\ArgumentNotAllowed;
use ExtendsFramework\Console\Parser\Posix\Exception\MissingArgument;
use ExtendsFramework\Console\Parser\Posix\Exception\MissingOperand;
use ExtendsFramework\Container\Container;
use ExtendsFramework\Container\ContainerInterface;

class PosixParser implements ParserInterface
{
    /**
     * @inheritDoc
     */
    public function parse(DefinitionInterface $definition, array $arguments, bool $strict = null): ContainerInterface
    {
        $strict = $strict ?? true;
        $parsed = new Container(
            $this->parseArguments($definition, $arguments, $strict)
        );

        if ($strict === true) {
            foreach ($definition->getOperands() as $operand) {
                $name = $operand->getName();
                if ($parsed->has($name) === false) {
                    throw new MissingOperand($name);
                }
            }
        }

        return $parsed;
    }

    /**
     * Parse $arguments against $definition in $strict mode.
     *
     * @param DefinitionInterface $definition
     * @param array               $arguments
     * @param bool|null           $strict
     * @return array
     * @throws ArgumentNotAllowed
     * @throws DefinitionException
     * @throws MissingArgument
     */
    protected function parseArguments(DefinitionInterface $definition, array $arguments, bool $strict): array
    {
        $operandPosition = 0;
        $terminated = false;
        $parsed = [];

        $iterator = new ArrayIterator($arguments);
        foreach ($iterator as $argument) {
            $argument = trim($argument);

            if ($terminated === true) {
                $operand = $this->getOperand($definition, $operandPosition++, $strict);
                if ($operand instanceof OperandInterface) {
                    $parsed[$operand->getName()] = $argument;
                }
            } elseif ($argument === '--') {
                $terminated = true;
            } elseif (strpos($argument, '--') === 0) {
                $argument = substr($argument, 2);
                $argument = explode('=', $argument, 2);
                $hasArgument = isset($argument[1]);

                $option = $this->getOption($definition, $argument[0], true, $strict);
                if ($option instanceof OptionInterface) {
                    $name = $option->getName();
                    if ($option->isFlag() === true) {
                        if ($hasArgument === true) {
                            throw new ArgumentNotAllowed($option, true);
                        }

                        if ($option->isMultiple() === true) {
                            $parsed[$name] = ($parsed[$name] ?? 0) + 1;
                        } else {
                            $parsed[$name] = true;
                        }
                    } elseif ($hasArgument === true) {
                        $parsed[$name] = $argument[1];
                    } else {
                        $iterator->next();
                        if ($iterator->valid() === true) {
                            $parsed[$name] = $iterator->current();
                        } elseif ($option->isFlag() === false) {
                            throw new MissingArgument($option, true);
                        }
                    }
                }
            } elseif (strpos($argument, '-') === 0) {
                $argument = substr($argument, 1);

                $parts = str_split($argument);
                foreach ($parts as $index => $part) {
                    $option = $this->getOption($definition, $part, false, $strict);
                    if ($option instanceof OptionInterface) {
                        $name = $option->getName();
                        if ($option->isFlag() === true) {
                            if ($option->isMultiple() === true) {
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
                            $iterator->next();
                            if ($iterator->valid() === true) {
                                $parsed[$name] = $iterator->current();
                            } elseif ($option->isFlag() === false) {
                                throw new MissingArgument($option);
                            }
                        }
                    }
                }
            } else {
                $operand = $this->getOperand($definition, $operandPosition++, $strict);
                if ($operand instanceof OperandInterface) {
                    $parsed[$operand->getName()] = $argument;
                }
            }
        }

        return $parsed;
    }

    /**
     * Get operand at $position from $definition.
     *
     * When $strict is true, an exception will be (re)thrown when operand doesn't exist.
     *
     * @param DefinitionInterface $definition
     * @param int                 $position
     * @param bool                $strict
     * @return OperandInterface|null
     * @throws DefinitionException
     */
    protected function getOperand(DefinitionInterface $definition, int $position, bool $strict): ?OperandInterface
    {
        try {
            $operand = $definition->getOperand($position);
        } catch (DefinitionException $exception) {
            if ($strict === true) {
                throw $exception;
            }
        }

        return $operand ?? null;
    }

    /**
     * Get option $name from $definition.
     *
     * When $strict is true, an exception will be (re)thrown when option doesn't exist.
     *
     * @param DefinitionInterface $definition
     * @param string              $name
     * @param bool                $long
     * @param bool                $strict
     * @return OptionInterface|null
     * @throws DefinitionException
     */
    protected function getOption(DefinitionInterface $definition, string $name, bool $long, bool $strict): ?OptionInterface
    {
        try {
            $option = $definition->getOption($name, $long);
        } catch (DefinitionException $exception) {
            if ($strict === true) {
                throw $exception;
            }
        }

        return $option ?? null;
    }
}
