<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Parser\Posix;

use ExtendsFramework\Console\Definition\DefinitionInterface;
use ExtendsFramework\Console\Definition\Operand\OperandInterface;
use ExtendsFramework\Console\Definition\Option\OptionInterface;
use ExtendsFramework\Container\ContainerInterface;
use PHPUnit\Framework\TestCase;

class PosixParserTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::parse()
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::parseArguments()
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

        /**
         * @var DefinitionInterface $definition
         */
        $parser = new PosixParser();
        $match = $parser->parse($definition, [
            '-fJohn',
            '-l=Doe',
        ]);

        $this->assertInstanceOf(ContainerInterface::class, $match);
        $this->assertSame([
            'first' => 'John',
            'last' => 'Doe',
        ], $match->extract());
    }

    /**
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::parse()
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::parseArguments()
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

        /**
         * @var DefinitionInterface $definition
         */
        $parser = new PosixParser();
        $match = $parser->parse($definition, [
            '-n',
            'John Doe',
        ]);

        $this->assertInstanceOf(ContainerInterface::class, $match);
        $this->assertSame([
            'name' => 'John Doe',
        ], $match->extract());
    }

    /**
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::parse()
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::parseArguments()
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

        /**
         * @var DefinitionInterface $definition
         */
        $parser = new PosixParser();
        $match = $parser->parse($definition, [
            '-f',
            '-b',
            '-b',
        ]);

        $this->assertInstanceOf(ContainerInterface::class, $match);
        $this->assertSame([
            'foo' => true,
            'bar' => true,
        ], $match->extract());
    }

    /**
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::parse()
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::parseArguments()
     */
    public function testCanParseShortOptionFlagAsMultiple(): void
    {
        $option = $this->createMock(OptionInterface::class);
        $option
            ->expects($this->exactly(3))
            ->method('getName')
            ->willReturnOnConsecutiveCalls(
                'verbose',
                'verbose',
                'verbose'
            );

        $option
            ->expects($this->exactly(3))
            ->method('isFlag')
            ->willReturn(true);

        $option
            ->expects($this->exactly(3))
            ->method('isMultiple')
            ->willReturn(true);

        $definition = $this->createMock(DefinitionInterface::class);
        $definition
            ->expects($this->exactly(3))
            ->method('getOption')
            ->withConsecutive(
                ['v'],
                ['v'],
                ['v']
            )
            ->willReturn($option);

        /**
         * @var DefinitionInterface $definition
         */
        $parser = new PosixParser();
        $match = $parser->parse($definition, [
            '-v',
            '-v',
            '-v',
        ]);

        $this->assertInstanceOf(ContainerInterface::class, $match);
        $this->assertSame([
            'verbose' => 3,
        ], $match->extract());
    }

    /**
     * @covers                   \ExtendsFramework\Console\Parser\Posix\PosixParser::parse()
     * @covers                   \ExtendsFramework\Console\Parser\Posix\PosixParser::parseArguments()
     * @covers                   \ExtendsFramework\Console\Parser\Posix\Exception\MissingArgument::__construct()
     * @expectedException        \ExtendsFramework\Console\Parser\Posix\Exception\MissingArgument
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

        /**
         * @var DefinitionInterface $definition
         */
        $parser = new PosixParser();
        $parser->parse($definition, [
            '-f',
        ]);
    }

    /**
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::parse()
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::parseArguments()
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

        /**
         * @var DefinitionInterface $definition
         */
        $parser = new PosixParser();
        $match = $parser->parse($definition, [
            '-fbq',
            'quux',
        ]);

        $this->assertInstanceOf(ContainerInterface::class, $match);
        $this->assertSame([
            'foo' => true,
            'bar' => true,
            'qux' => 'quux',
        ], $match->extract());
    }

    /**
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::parse()
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::parseArguments()
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

        /**
         * @var DefinitionInterface $definition
         */
        $parser = new PosixParser();
        $match = $parser->parse($definition, [
            '--name=John Doe',
        ]);

        $this->assertInstanceOf(ContainerInterface::class, $match);
        $this->assertSame([
            'name' => 'John Doe',
        ], $match->extract());
    }

    /**
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::parse()
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::parseArguments()
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

        /**
         * @var DefinitionInterface $definition
         */
        $parser = new PosixParser();
        $match = $parser->parse($definition, [
            '--name',
            'John Doe',
        ]);

        $this->assertInstanceOf(ContainerInterface::class, $match);
        $this->assertSame([
            'name' => 'John Doe',
        ], $match->extract());
    }

    /**
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::parse()
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::parseArguments()
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

        /**
         * @var DefinitionInterface $definition
         */
        $parser = new PosixParser();
        $match = $parser->parse($definition, [
            '--force',
        ]);

        $this->assertInstanceOf(ContainerInterface::class, $match);
        $this->assertSame([
            'force' => true,
        ], $match->extract());
    }

    /**
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::parse()
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::parseArguments()
     */
    public function testCanParseLongOptionFlagAsMultiple(): void
    {
        $option = $this->createMock(OptionInterface::class);
        $option
            ->expects($this->exactly(2))
            ->method('getName')
            ->willReturn('verbose');

        $option
            ->expects($this->exactly(2))
            ->method('isFlag')
            ->willReturn(true);

        $option
            ->expects($this->exactly(2))
            ->method('isMultiple')
            ->willReturn(true);

        $definition = $this->createMock(DefinitionInterface::class);
        $definition
            ->expects($this->exactly(2))
            ->method('getOption')
            ->with('verbose', true)
            ->willReturn($option);

        /**
         * @var DefinitionInterface $definition
         */
        $parser = new PosixParser();
        $match = $parser->parse($definition, [
            '--verbose',
            '--verbose',
        ]);

        $this->assertInstanceOf(ContainerInterface::class, $match);
        $this->assertSame([
            'verbose' => 2,
        ], $match->extract());
    }

    /**
     * @covers                   \ExtendsFramework\Console\Parser\Posix\PosixParser::parse()
     * @covers                   \ExtendsFramework\Console\Parser\Posix\PosixParser::parseArguments()
     * @covers                   \ExtendsFramework\Console\Parser\Posix\Exception\ArgumentNotAllowed::__construct()
     * @expectedException        \ExtendsFramework\Console\Parser\Posix\Exception\ArgumentNotAllowed
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

        /**
         * @var DefinitionInterface $definition
         */
        $parser = new PosixParser();
        $parser->parse($definition, [
            '--name=John Doe',
        ]);
    }

    /**
     * @covers                   \ExtendsFramework\Console\Parser\Posix\PosixParser::parse()
     * @covers                   \ExtendsFramework\Console\Parser\Posix\PosixParser::parseArguments()
     * @covers                   \ExtendsFramework\Console\Parser\Posix\Exception\MissingArgument::__construct()
     * @expectedException        \ExtendsFramework\Console\Parser\Posix\Exception\MissingArgument
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

        /**
         * @var DefinitionInterface $definition
         */
        $parser = new PosixParser();
        $parser->parse($definition, [
            '--name',
        ]);
    }

    /**
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::parse()
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::parseArguments()
     */
    public function testCanParseOperand(): void
    {
        $operand = $this->createMock(OperandInterface::class);
        $operand
            ->expects($this->exactly(2))
            ->method('getName')
            ->willReturn('name.first');

        $definition = $this->createMock(DefinitionInterface::class);
        $definition
            ->expects($this->once())
            ->method('getOperand')
            ->with(0)
            ->willReturn($operand);

        $definition
            ->expects($this->once())
            ->method('getOperands')
            ->willReturn([
                $operand,
            ]);

        /**
         * @var DefinitionInterface $definition
         */
        $parser = new PosixParser();
        $match = $parser->parse($definition, [
            'John Doe',
        ]);

        $this->assertInstanceOf(ContainerInterface::class, $match);
        $this->assertSame([
            'name.first' => 'John Doe',
        ], $match->extract());
    }

    /**
     * @covers                   \ExtendsFramework\Console\Parser\Posix\PosixParser::parse()
     * @covers                   \ExtendsFramework\Console\Parser\Posix\PosixParser::parseArguments()
     * @covers                   \ExtendsFramework\Console\Parser\Posix\Exception\MissingOperand::__construct()
     * @expectedException        \ExtendsFramework\Console\Parser\Posix\Exception\MissingOperand
     * @expectedExceptionMessage Operand "name.first" is required.
     */
    public function testCanNotParseMissingOperand(): void
    {
        $operand = $this->createMock(OperandInterface::class);
        $operand
            ->expects($this->once())
            ->method('getName')
            ->willReturn('name.first');

        $definition = $this->createMock(DefinitionInterface::class);
        $definition
            ->expects($this->once())
            ->method('getOperands')
            ->willReturn([
                $operand,
            ]);

        /**
         * @var DefinitionInterface $definition
         */
        $parser = new PosixParser();
        $parser->parse($definition, []);
    }

    /**
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::parse()
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::parseArguments()
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

        /**
         * @var DefinitionInterface $definition
         */
        $parser = new PosixParser();
        $match = $parser->parse($definition, [
            '--',
            '-John',
            '--Doe',
        ]);

        $this->assertInstanceOf(ContainerInterface::class, $match);
        $this->assertSame([
            'first' => '-John',
            'last' => '--Doe',
        ], $match->extract());
    }
}
