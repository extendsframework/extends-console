<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Arguments\Definition;

use ExtendsFramework\Console\Arguments\Definition\Exception\OperandNotFound;
use ExtendsFramework\Console\Arguments\Definition\Exception\OptionNotFound;
use ExtendsFramework\Console\Arguments\Definition\Operand\OperandInterface;
use ExtendsFramework\Console\Arguments\Definition\Option\OptionInterface;

interface DefinitionInterface
{
    /**
     * Get all options.
     *
     * @return OptionInterface[]
     */
    public function getOptions(): array;

    /**
     * Get all operands.
     *
     * @return OperandInterface[]
     */
    public function getOperands(): array;

    /**
     * Get option for $name.
     *
     * Throws an exception when option with short $name is not found.
     *
     * @param string    $name
     * @param bool|null $long
     * @return OptionInterface
     * @throws OptionNotFound
     */
    public function getOption(string $name, bool $long = null): OptionInterface;

    /**
     * Get operand for $position.
     *
     * Throws an exception when operand at $position is not found.
     *
     * @param int $position
     * @return OperandInterface
     * @throws OperandNotFound
     */
    public function getOperand(int $position): OperandInterface;
}
