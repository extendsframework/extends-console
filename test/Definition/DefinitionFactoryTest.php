<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Definition;

use ExtendsFramework\Console\Definition\Operand\OperandFactoryInterface;
use ExtendsFramework\Console\Definition\Operand\OperandInterface;
use ExtendsFramework\Console\Definition\Option\OptionFactoryInterface;
use ExtendsFramework\Console\Definition\Option\OptionInterface;
use PHPUnit\Framework\TestCase;

class DefinitionFactoryTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Definition\DefinitionFactory::__construct()
     * @covers \ExtendsFramework\Console\Definition\DefinitionFactory::create()
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
