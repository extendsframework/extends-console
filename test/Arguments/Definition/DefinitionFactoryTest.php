<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Arguments\Definition;

use ExtendsFramework\Console\Arguments\Definition\Operand\OperandFactoryInterface;
use ExtendsFramework\Console\Arguments\Definition\Operand\OperandInterface;
use ExtendsFramework\Console\Arguments\Definition\Option\OptionFactoryInterface;
use ExtendsFramework\Console\Arguments\Definition\Option\OptionInterface;
use PHPUnit\Framework\TestCase;

class DefinitionFactoryTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Arguments\Definition\DefinitionFactory::__construct()
     * @covers \ExtendsFramework\Console\Arguments\Definition\DefinitionFactory::create()
     */
    public function testCanCreateDefinitionFromArguments(): void
    {
        $option = $this->createMock(OptionInterface::class);

        $optionFactory = $this->createMock(OptionFactoryInterface::class);
        $optionFactory
            ->expects($this->once())
            ->method('create')
            ->with([
                'name' => 'register',
                'short' => 'f',
            ])
            ->willReturn($option);

        $operand = $this->createMock(OperandInterface::class);

        $operandFactory = $this->createMock(OperandFactoryInterface::class);
        $operandFactory
            ->expects($this->once())
            ->method('create')
            ->with([
                'name' => 'name',
            ])
            ->willReturn($operand);

        /**
         * @var OptionFactoryInterface  $optionFactory
         * @var OperandFactoryInterface $operandFactory
         */
        $factory = new DefinitionFactory($optionFactory, $operandFactory);
        $definition = $factory->create([
            'operands' => [
                [
                    'name' => 'name',
                ],
            ],
            'options' => [
                [
                    'name' => 'register',
                    'short' => 'f',
                ],
            ],
        ]);

        $this->assertInstanceOf(Definition::class, $definition);
    }
}
