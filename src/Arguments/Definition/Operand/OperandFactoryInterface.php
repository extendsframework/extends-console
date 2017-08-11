<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Arguments\Definition\Operand;

interface OperandFactoryInterface
{
    /**
     * Create new OperandInterface from $config.
     *
     * @param array $config
     * @return OperandInterface
     */
    public function create(array $config): OperandInterface;
}
