<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Definition\Operand;

interface OperandInterface
{
    /**
     * Get operand name.
     *
     * @return string
     */
    public function getName(): string;
}
