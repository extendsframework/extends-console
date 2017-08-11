<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Arguments\Definition\Operand;

interface OperandInterface
{
    /**
     * Get operand name.
     *
     * @return string
     */
    public function getName(): string;
}
