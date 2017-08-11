<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Arguments\Parser\Posix;

use ExtendsFramework\Console\Arguments\ArgumentsInterface;
use ExtendsFramework\Console\Arguments\Definition\DefinitionInterface;
use ExtendsFramework\Console\Arguments\Definition\Operand\OperandInterface;
use ExtendsFramework\Console\Arguments\Definition\Option\OptionInterface;
use ExtendsFramework\Container\ContainerInterface;
use PHPUnit\Framework\TestCase;

class PosixParserTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Arguments\Parser\Posix\PosixParser::parse()
     */
    public function testCanParseShortOptionWithCombinedArgument(): void
    {
        $option = $this->createMock(OptionInterface::class);
        $option
            ->expects($this->exactly(2))
            ->method('getName')
            ->willReturnOnConsecutiveCalls(
                'first',
                'last'
            );

        $option
            ->expects($this->exactly(2))
            ->method('isFlag')
            ->willReturn(false);

        $definition = $this->createMock(DefinitionInterface::class);
        $definition
            ->expects($this->exactly(2))
            ->method('getOption')
            ->withConsecutive(
                ['f'],
                ['l']
            )
            ->willReturn($option);

        $arguments = $this->createMock(ArgumentsInterface::class);
        $arguments
            ->method('valid')
            ->willReturnOnConsecutiveCalls(
                true,
                true
            );

        $arguments
            ->method('current')
            ->willReturnOnConsecutiveCalls(
                '-fJohn',
                '-l=Doe'
            );

        /**
         * @var DefinitionInterface $definition
         * @var ArgumentsInterface  $arguments
         */
        $parser = new PosixParser();
        $match = $parser->parse($definition, $arguments);

        $this->assertInstanceOf(ContainerInterface::class, $match);
        $this->assertSame([
            'first' => 'John',
            'last' => 'Doe',
        ], $match->extract());
    }

    /**
     * @covers \ExtendsFramework\Console\Arguments\Parser\Posix\PosixParser::parse()
     */
    public function testCanParseShortOptionWithSeparateArgument(): void
    {
        $option = $this->createMock(OptionInterface::class);
        $option
            ->expects($this->once())
            ->method('getName')
            ->willReturn('name');

        $option
            ->expects($this->once())
            ->method('isFlag')
            ->willReturn(false);

        $definition = $this->createMock(DefinitionInterface::class);
        $definition
            ->expects($this->once())
            ->method('getOption')
            ->with('n')
            ->willReturn($option);

        $arguments = $this->createMock(ArgumentsInterface::class);
        $arguments
            ->method('valid')
            ->willReturnOnConsecutiveCalls(
                true,
                true
            );

        $arguments
            ->method('current')
            ->willReturnOnConsecutiveCalls(
                '-n',
                'John Doe'
            );

        /**
         * @var DefinitionInterface $definition
         * @var ArgumentsInterface  $arguments
         */
        $parser = new PosixParser();
        $match = $parser->parse($definition, $arguments);

        $this->assertInstanceOf(ContainerInterface::class, $match);
        $this->assertSame([
            'name' => 'John Doe',
        ], $match->extract());
    }

    /**
     * @covers \ExtendsFramework\Console\Arguments\Parser\Posix\PosixParser::parse()
     */
    public function testCanParseShortOptionFlag(): void
    {
        $option = $this->createMock(OptionInterface::class);
        $option
            ->expects($this->exactly(3))
            ->method('getName')
            ->willReturnOnConsecutiveCalls(
                'foo',
                'bar',
                'bar'
            );

        $option
            ->expects($this->exactly(3))
            ->method('isFlag')
            ->willReturn(true);

        $definition = $this->createMock(DefinitionInterface::class);
        $definition
            ->expects($this->exactly(3))
            ->method('getOption')
            ->withConsecutive(
                ['f'],
                ['b'],
                ['b']
            )
            ->willReturn($option);

        $arguments = $this->createMock(ArgumentsInterface::class);
        $arguments
            ->method('valid')
            ->willReturnOnConsecutiveCalls(
                true,
                true,
                true
            );

        $arguments
            ->method('current')
            ->willReturnOnConsecutiveCalls(
                '-f',
                '-b',
                '-b'
            );

        /**
         * @var DefinitionInterface $definition
         * @var ArgumentsInterface  $arguments
         */
        $parser = new PosixParser();
        $match = $parser->parse($definition, $arguments);

        $this->assertInstanceOf(ContainerInterface::class, $match);
        $this->assertSame([
            'foo' => true,
            'bar' => true,
        ], $match->extract());
    }

    /**
     * @covers                   \ExtendsFramework\Console\Arguments\Parser\Posix\PosixParser::parse()
     * @covers                   \ExtendsFramework\Console\Arguments\Parser\Posix\Exception\RequiredOptionWithoutArgument::__construct()
     * @expectedException        \ExtendsFramework\Console\Arguments\Parser\Posix\Exception\RequiredOptionWithoutArgument
     * @expectedExceptionMessage Short option "-f" requires an argument, non given.
     */
    public function testCanNotParseRequiredShortOptionWithoutArgument(): void
    {
        $option = $this->createMock(OptionInterface::class);
        $option
            ->expects($this->once())
            ->method('getName')
            ->willReturn('foo');

        $option
            ->expects($this->once())
            ->method('isFlag')
            ->willReturn(false);

        $option
            ->expects($this->once())
            ->method('isRequired')
            ->willReturn(true);

        $option
            ->expects($this->once())
            ->method('getShort')
            ->willReturn('f');

        $definition = $this->createMock(DefinitionInterface::class);
        $definition
            ->expects($this->once())
            ->method('getOption')
            ->with('f')
            ->willReturn($option);

        $arguments = $this->createMock(ArgumentsInterface::class);
        $arguments
            ->method('valid')
            ->willReturnOnConsecutiveCalls(
                true
            );

        $arguments
            ->method('current')
            ->willReturnOnConsecutiveCalls(
                '-f'
            );

        /**
         * @var DefinitionInterface $definition
         * @var ArgumentsInterface  $arguments
         */
        $parser = new PosixParser();
        $parser->parse($definition, $arguments);
    }

    /**
     * @covers \ExtendsFramework\Console\Arguments\Parser\Posix\PosixParser::parse()
     */
    public function testCanParseCombinedShortOptions(): void
    {
        $option = $this->createMock(OptionInterface::class);
        $option
            ->expects($this->exactly(3))
            ->method('getName')
            ->willReturnOnConsecutiveCalls(
                'foo',
                'bar',
                'qux'
            );

        $option
            ->expects($this->exactly(3))
            ->method('isFlag')
            ->willReturnOnConsecutiveCalls(
                true,
                true,
                false
            );

        $definition = $this->createMock(DefinitionInterface::class);
        $definition
            ->expects($this->exactly(3))
            ->method('getOption')
            ->withConsecutive(
                ['f'],
                ['b'],
                ['q']
            )
            ->willReturn($option);

        $arguments = $this->createMock(ArgumentsInterface::class);
        $arguments
            ->expects($this->exactly(3))
            ->method('valid')
            ->willReturnOnConsecutiveCalls(
                true,
                true
            );

        $arguments
            ->method('current')
            ->willReturnOnConsecutiveCalls(
                '-fbq',
                'quux'
            );

        /**
         * @var DefinitionInterface $definition
         * @var ArgumentsInterface  $arguments
         */
        $parser = new PosixParser();
        $match = $parser->parse($definition, $arguments);

        $this->assertInstanceOf(ContainerInterface::class, $match);
        $this->assertSame([
            'foo' => true,
            'bar' => true,
            'qux' => 'quux',
        ], $match->extract());
    }

    /**
     * @covers \ExtendsFramework\Console\Arguments\Parser\Posix\PosixParser::parse()
     */
    public function testCanParseLongOptionWithCombinedArgument(): void
    {
        $option = $this->createMock(OptionInterface::class);
        $option
            ->expects($this->once())
            ->method('getName')
            ->willReturn('name');

        $option
            ->expects($this->once())
            ->method('isFlag')
            ->willReturn(false);

        $definition = $this->createMock(DefinitionInterface::class);
        $definition
            ->expects($this->once())
            ->method('getOption')
            ->with('name', true)
            ->willReturn($option);

        $arguments = $this->createMock(ArgumentsInterface::class);
        $arguments
            ->method('valid')
            ->willReturnOnConsecutiveCalls(
                true
            );

        $arguments
            ->method('current')
            ->willReturn('--name=John Doe');

        /**
         * @var DefinitionInterface $definition
         * @var ArgumentsInterface  $arguments
         */
        $parser = new PosixParser();
        $match = $parser->parse($definition, $arguments);

        $this->assertInstanceOf(ContainerInterface::class, $match);
        $this->assertSame([
            'name' => 'John Doe',
        ], $match->extract());
    }

    /**
     * @covers \ExtendsFramework\Console\Arguments\Parser\Posix\PosixParser::parse()
     */
    public function testCanParseLongOptionWithSeparateArgument(): void
    {
        $option = $this->createMock(OptionInterface::class);
        $option
            ->expects($this->once())
            ->method('getName')
            ->willReturn('name');

        $option
            ->expects($this->once())
            ->method('isFlag')
            ->willReturn(false);

        $definition = $this->createMock(DefinitionInterface::class);
        $definition
            ->expects($this->once())
            ->method('getOption')
            ->with('name', true)
            ->willReturn($option);

        $arguments = $this->createMock(ArgumentsInterface::class);
        $arguments
            ->method('valid')
            ->willReturnOnConsecutiveCalls(
                true,
                true
            );

        $arguments
            ->method('current')
            ->willReturnOnConsecutiveCalls(
                '--name',
                'John Doe'
            );

        /**
         * @var DefinitionInterface $definition
         * @var ArgumentsInterface  $arguments
         */
        $parser = new PosixParser();
        $match = $parser->parse($definition, $arguments);

        $this->assertInstanceOf(ContainerInterface::class, $match);
        $this->assertSame([
            'name' => 'John Doe',
        ], $match->extract());
    }

    /**
     * @covers \ExtendsFramework\Console\Arguments\Parser\Posix\PosixParser::parse()
     */
    public function testCanParseLongOptionFlag(): void
    {
        $option = $this->createMock(OptionInterface::class);
        $option
            ->expects($this->once())
            ->method('getName')
            ->willReturn('force');

        $option
            ->expects($this->once())
            ->method('isFlag')
            ->willReturn(true);

        $definition = $this->createMock(DefinitionInterface::class);
        $definition
            ->expects($this->once())
            ->method('getOption')
            ->with('force', true)
            ->willReturn($option);

        $arguments = $this->createMock(ArgumentsInterface::class);
        $arguments
            ->method('valid')
            ->willReturnOnConsecutiveCalls(
                true
            );

        $arguments
            ->method('current')
            ->willReturn('--force');

        /**
         * @var DefinitionInterface $definition
         * @var ArgumentsInterface  $arguments
         */
        $parser = new PosixParser();
        $match = $parser->parse($definition, $arguments);

        $this->assertInstanceOf(ContainerInterface::class, $match);
        $this->assertSame([
            'force' => true,
        ], $match->extract());
    }

    /**
     * @covers                   \ExtendsFramework\Console\Arguments\Parser\Posix\PosixParser::parse()
     * @covers                   \ExtendsFramework\Console\Arguments\Parser\Posix\Exception\FlagOptionWithArgument::__construct()
     * @expectedException        \ExtendsFramework\Console\Arguments\Parser\Posix\Exception\FlagOptionWithArgument
     * @expectedExceptionMessage Long option argument is not allowed for flag "--name".
     */
    public function testCanNotParseLongOptionFlagWithArgument(): void
    {
        $option = $this->createMock(OptionInterface::class);
        $option
            ->expects($this->once())
            ->method('isFlag')
            ->willReturn(true);

        $option
            ->expects($this->once())
            ->method('getLong')
            ->willReturn('name');

        $definition = $this->createMock(DefinitionInterface::class);
        $definition
            ->expects($this->once())
            ->method('getOption')
            ->with('name', true)
            ->willReturn($option);

        $arguments = $this->createMock(ArgumentsInterface::class);
        $arguments
            ->method('valid')
            ->willReturnOnConsecutiveCalls(
                true
            );

        $arguments
            ->method('current')
            ->willReturn('--name=John Doe');

        /**
         * @var DefinitionInterface $definition
         * @var ArgumentsInterface  $arguments
         */
        $parser = new PosixParser();
        $parser->parse($definition, $arguments);
    }

    /**
     * @covers                   \ExtendsFramework\Console\Arguments\Parser\Posix\PosixParser::parse()
     * @covers                   \ExtendsFramework\Console\Arguments\Parser\Posix\Exception\RequiredOptionWithoutArgument::__construct()
     * @expectedException        \ExtendsFramework\Console\Arguments\Parser\Posix\Exception\RequiredOptionWithoutArgument
     * @expectedExceptionMessage Long option "--name" requires an argument, non given.
     */
    public function testCanNotParseRequiredLongOptionWithoutArgument(): void
    {
        $option = $this->createMock(OptionInterface::class);
        $option
            ->expects($this->once())
            ->method('isFlag')
            ->willReturn(false);

        $option
            ->expects($this->once())
            ->method('isRequired')
            ->willReturn(true);

        $option
            ->expects($this->once())
            ->method('getLong')
            ->willReturn('name');

        $definition = $this->createMock(DefinitionInterface::class);
        $definition
            ->expects($this->once())
            ->method('getOption')
            ->with('name', true)
            ->willReturn($option);

        $arguments = $this->createMock(ArgumentsInterface::class);
        $arguments
            ->method('valid')
            ->willReturnOnConsecutiveCalls(
                true
            );

        $arguments
            ->method('current')
            ->willReturnOnConsecutiveCalls(
                '--name'
            );

        /**
         * @var DefinitionInterface $definition
         * @var ArgumentsInterface  $arguments
         */
        $parser = new PosixParser();
        $parser->parse($definition, $arguments);
    }

    /**
     * @covers \ExtendsFramework\Console\Arguments\Parser\Posix\PosixParser::parse()
     */
    public function testCanParseOperand(): void
    {
        $operand = $this->createMock(OperandInterface::class);
        $operand
            ->expects($this->once())
            ->method('getName')
            ->willReturn('name');

        $definition = $this->createMock(DefinitionInterface::class);
        $definition
            ->expects($this->once())
            ->method('getOperand')
            ->with(0)
            ->willReturn($operand);

        $arguments = $this->createMock(ArgumentsInterface::class);
        $arguments
            ->method('valid')
            ->willReturnOnConsecutiveCalls(
                true
            );

        $arguments
            ->method('current')
            ->willReturnOnConsecutiveCalls(
                'John Doe'
            );

        /**
         * @var DefinitionInterface $definition
         * @var ArgumentsInterface  $arguments
         */
        $parser = new PosixParser();
        $match = $parser->parse($definition, $arguments);

        $this->assertInstanceOf(ContainerInterface::class, $match);
        $this->assertSame([
            'name' => 'John Doe',
        ], $match->extract());
    }

    /**
     * @covers \ExtendsFramework\Console\Arguments\Parser\Posix\PosixParser::parse()
     */
    public function testCanTerminatedFurtherOptionsToOperands(): void
    {
        $operand1 = $this->createMock(OperandInterface::class);
        $operand1
            ->expects($this->once())
            ->method('getName')
            ->willReturn('first');

        $operand2 = $this->createMock(OperandInterface::class);
        $operand2
            ->expects($this->once())
            ->method('getName')
            ->willReturn('last');

        $definition = $this->createMock(DefinitionInterface::class);
        $definition
            ->expects($this->exactly(2))
            ->method('getOperand')
            ->withConsecutive(
                [0],
                [1]
            )
            ->willReturnOnConsecutiveCalls(
                $operand1,
                $operand2
            );

        $arguments = $this->createMock(ArgumentsInterface::class);
        $arguments
            ->method('valid')
            ->willReturnOnConsecutiveCalls(
                true,
                true,
                true
            );

        $arguments
            ->method('current')
            ->willReturnOnConsecutiveCalls(
                '--',
                '-John',
                '--Doe'
            );

        /**
         * @var DefinitionInterface $definition
         * @var ArgumentsInterface  $arguments
         */
        $parser = new PosixParser();
        $match = $parser->parse($definition, $arguments);

        $this->assertInstanceOf(ContainerInterface::class, $match);
        $this->assertSame([
            'first' => '-John',
            'last' => '--Doe',
        ], $match->extract());
    }
}
