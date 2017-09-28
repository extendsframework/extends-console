<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Definition;

use ExtendsFramework\Console\Definition\Operand\OperandInterface;
use ExtendsFramework\Console\Definition\Option\OptionInterface;
use PHPUnit\Framework\TestCase;

class DefinitionTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Definition\Definition::addOption()
     * @covers \ExtendsFramework\Console\Definition\Definition::addOperand()
     * @covers \ExtendsFramework\Console\Definition\Definition::getOption()
     * @covers \ExtendsFramework\Console\Definition\Definition::getOperand()
     * @covers \ExtendsFramework\Console\Definition\Definition::getOptions()
     * @covers \ExtendsFramework\Console\Definition\Definition::getOperands()
     */
    public function testCanAddAndGetArgument(): void
    {
        $short = $this->createMock(OptionInterface::class);
        $short
            ->expects($this->exactly(1))
            ->method('getShort')
            ->willReturn('f');

        $short
            ->expects($this->once())
            ->method('getLong')
            ->willReturn(null);

        $long = $this->createMock(OptionInterface::class);

        $long
            ->expects($this->once())
            ->method('getLong')
            ->willReturn('force');

        $operand = $this->createMock(OperandInterface::class);

        /**
         * @var OptionInterface  $short
         * @var OptionInterface  $long
         * @var OperandInterface $operand
         */
        $definition = new Definition();
        $definition
            ->addOption($short)
            ->addOption($long)
            ->addOperand($operand)
            ->addOperand($operand);

        $this->assertSame($short, $definition->getOption('f'));
        $this->assertSame($long, $definition->getOption('force', true));
        $this->assertSame($operand, $definition->getOperand(1));

        $this->assertContainsOnlyInstancesOf(OptionInterface::class, $definition->getOptions());
        $this->assertContainsOnlyInstancesOf(OperandInterface::class, $definition->getOperands());
    }

    /**
     * @covers                   \ExtendsFramework\Console\Definition\Definition::getOption()
     * @covers                   \ExtendsFramework\Console\Definition\Exception\OptionNotFound::__construct()
     * @expectedException        \ExtendsFramework\Console\Definition\Exception\OptionNotFound
     * @expectedExceptionMessage No short option found for name "-f".
     */
    public function testCanNotGetShortOption(): void
    {
        $definition = new Definition();
        $definition->getOption('f');
    }

    /**
     * @covers                   \ExtendsFramework\Console\Definition\Definition::getOption()
     * @covers                   \ExtendsFramework\Console\Definition\Exception\OptionNotFound::__construct()
     * @expectedException        \ExtendsFramework\Console\Definition\Exception\OptionNotFound
     * @expectedExceptionMessage No long option found for name "--force".
     */
    public function testCanNotGetLongOption(): void
    {
        $definition = new Definition();
        $definition->getOption('force', true);
    }

    /**
     * @covers                   \ExtendsFramework\Console\Definition\Definition::getOperand()
     * @covers                   \ExtendsFramework\Console\Definition\Exception\OperandNotFound::__construct()
     * @expectedException        \ExtendsFramework\Console\Definition\Exception\OperandNotFound
     * @expectedExceptionMessage No operand found for position "0".
     */
    public function testCanNotGetOperand(): void
    {
        $definition = new Definition();
        $definition->getOperand(0);
    }
}
