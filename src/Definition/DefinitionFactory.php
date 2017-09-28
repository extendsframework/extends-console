<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Definition;

use ExtendsFramework\Console\Definition\Operand\OperandFactoryInterface;
use ExtendsFramework\Console\Definition\Option\OptionFactoryInterface;

class DefinitionFactory implements DefinitionFactoryInterface
{
    /**
     * @var OptionFactoryInterface
     */
    protected $optionFactory;

    /**
     * @var OperandFactoryInterface
     */
    protected $operandFactory;

    /**
     * @param OptionFactoryInterface  $optionFactory
     * @param OperandFactoryInterface $operandFactory
     */
    public function __construct(OptionFactoryInterface $optionFactory, OperandFactoryInterface $operandFactory)
    {
        $this->optionFactory = $optionFactory;
        $this->operandFactory = $operandFactory;
    }

    /**
     * @inheritDoc
     */
    public function create(array $config): DefinitionInterface
    {
        $definition = new Definition();

        foreach ($config['operands'] ?? [] as $operand) {
            $operand = $this->operandFactory->create($operand);

            $definition->addOperand($operand);
        }

        foreach ($config['options'] ?? [] as $option) {
            $option = $this->optionFactory->create($option);

            $definition->addOption($option);
        }

        return $definition;
    }
}
