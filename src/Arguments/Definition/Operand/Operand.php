<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Arguments\Definition\Operand;

class Operand implements OperandInterface
{
    /**
     * Operand name.
     *
     * @var string
     */
    protected $name;

    /**
     * Create new OperandInterface with $name.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->name;
    }
}
