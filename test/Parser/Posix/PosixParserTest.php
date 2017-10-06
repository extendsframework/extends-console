<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Parser\Posix;

use ExtendsFramework\Console\Definition\DefinitionInterface;
use ExtendsFramework\Console\Definition\Exception\OperandNotFound;
use ExtendsFramework\Console\Definition\Exception\OptionNotFound;
use ExtendsFramework\Console\Definition\Operand\OperandInterface;
use ExtendsFramework\Console\Definition\Option\OptionInterface;
use ExtendsFramework\Console\Parser\ParseResultInterface;
use PHPUnit\Framework\TestCase;

class PosixParserTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::parse()
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::parseArguments()
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::getOption()
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
        $result = $parser->parse($definition, [
            '-fJohn',
            '-l=Doe',
        ]);

        $this->assertInstanceOf(ParseResultInterface::class, $result);
        if ($result instanceof ParseResultInterface) {
            $this->assertSame([
                'first' => 'John',
                'last' => 'Doe',
            ], $result->getParsed());
        }
    }

    /**
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::parse()
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::parseArguments()
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::getOption()
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
        $result = $parser->parse($definition, [
            '-n',
            'John Doe',
        ]);

        $this->assertInstanceOf(ParseResultInterface::class, $result);
        if ($result instanceof ParseResultInterface) {
            $this->assertSame([
                'name' => 'John Doe',
            ], $result->getParsed());
        }
    }

    /**
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::parse()
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::parseArguments()
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::getOption()
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
        $result = $parser->parse($definition, [
            '-f',
            '-b',
            '-b',
        ]);

        $this->assertInstanceOf(ParseResultInterface::class, $result);
        if ($result instanceof ParseResultInterface) {
            $this->assertSame([
                'foo' => true,
                'bar' => true,
            ], $result->getParsed());
        }
    }

    /**
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::parse()
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::parseArguments()
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::getOption()
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
        $result = $parser->parse($definition, [
            '-v',
            '-v',
            '-v',
        ]);

        $this->assertInstanceOf(ParseResultInterface::class, $result);
        if ($result instanceof ParseResultInterface) {
            $this->assertSame([
                'verbose' => 3,
            ], $result->getParsed());
        }
    }

    /**
     * @covers                   \ExtendsFramework\Console\Parser\Posix\PosixParser::parse()
     * @covers                   \ExtendsFramework\Console\Parser\Posix\PosixParser::parseArguments()
     * @covers                   \ExtendsFramework\Console\Parser\Posix\PosixParser::getOption()
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
            ->expects($this->exactly(2))
            ->method('isFlag')
            ->willReturn(false);

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
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::getOption()
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
        $result = $parser->parse($definition, [
            '-fbq',
            'quux',
        ]);

        $this->assertInstanceOf(ParseResultInterface::class, $result);
        if ($result instanceof ParseResultInterface) {
            $this->assertSame([
                'foo' => true,
                'bar' => true,
                'qux' => 'quux',
            ], $result->getParsed());
        }
    }

    /**
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::parse()
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::parseArguments()
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::getOption()
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
        $result = $parser->parse($definition, [
            '--name=John Doe',
        ]);

        $this->assertInstanceOf(ParseResultInterface::class, $result);
        if ($result instanceof ParseResultInterface) {
            $this->assertSame([
                'name' => 'John Doe',
            ], $result->getParsed());
        }
    }

    /**
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::parse()
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::parseArguments()
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::getOption()
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
        $result = $parser->parse($definition, [
            '--name',
            'John Doe',
        ]);

        $this->assertInstanceOf(ParseResultInterface::class, $result);
        if ($result instanceof ParseResultInterface) {
            $this->assertSame([
                'name' => 'John Doe',
            ], $result->getParsed());
        }
    }

    /**
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::parse()
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::parseArguments()
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::getOption()
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
        $result = $parser->parse($definition, [
            '--force',
        ]);

        $this->assertInstanceOf(ParseResultInterface::class, $result);
        if ($result instanceof ParseResultInterface) {
            $this->assertSame([
                'force' => true,
            ], $result->getParsed());
        }
    }

    /**
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::parse()
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::parseArguments()
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::getOption()
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
        $result = $parser->parse($definition, [
            '--verbose',
            '--verbose',
        ]);

        $this->assertInstanceOf(ParseResultInterface::class, $result);
        if ($result instanceof ParseResultInterface) {
            $this->assertSame([
                'verbose' => 2,
            ], $result->getParsed());
        }
    }

    /**
     * @covers                   \ExtendsFramework\Console\Parser\Posix\PosixParser::parse()
     * @covers                   \ExtendsFramework\Console\Parser\Posix\PosixParser::parseArguments()
     * @covers                   \ExtendsFramework\Console\Parser\Posix\PosixParser::getOption()
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
     * @covers                   \ExtendsFramework\Console\Parser\Posix\PosixParser::getOption()
     * @covers                   \ExtendsFramework\Console\Parser\Posix\Exception\MissingArgument::__construct()
     * @expectedException        \ExtendsFramework\Console\Parser\Posix\Exception\MissingArgument
     * @expectedExceptionMessage Long option "--name" requires an argument, non given.
     */
    public function testCanNotParseRequiredLongOptionWithoutArgument(): void
    {
        $option = $this->createMock(OptionInterface::class);
        $option
            ->expects($this->exactly(2))
            ->method('isFlag')
            ->willReturn(false);

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
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::getOperand()
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
        $result = $parser->parse($definition, [
            'John Doe',
        ]);

        $this->assertInstanceOf(ParseResultInterface::class, $result);
        if ($result instanceof ParseResultInterface) {
            $this->assertSame([
                'name.first' => 'John Doe',
            ], $result->getParsed());
        }
    }

    /**
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::parse()
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::parseArguments()
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::getOption()
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::getOperand()
     */
    public function testCanParseInNonStrictMode(): void
    {
        /**
         * @var OptionNotFound  $optionNotFound
         * @var OperandNotFound $operandNotFound
         */
        $optionNotFound = $this->createMock(OptionNotFound::class);
        $operandNotFound = $this->createMock(OperandNotFound::class);

        $definition = $this->createMock(DefinitionInterface::class);

        $option = $this->createMock(OptionInterface::class);
        $option
            ->expects($this->exactly(2))
            ->method('getName')
            ->willReturnOnConsecutiveCalls(
                'force',
                'quite'
            );

        $option
            ->expects($this->exactly(2))
            ->method('isFlag')
            ->willReturn(true);

        $option
            ->expects($this->exactly(2))
            ->method('isMultiple')
            ->willReturnOnConsecutiveCalls(
                true,
                false
            );

        $definition
            ->expects($this->exactly(5))
            ->method('getOption')
            ->withConsecutive(
                ['x'],
                ['f'],
                ['a'],
                ['help', true],
                ['quite', true]
            )
            ->willReturnOnConsecutiveCalls(
                $this->throwException($optionNotFound),
                $option,
                $this->throwException($optionNotFound),
                $this->throwException($optionNotFound),
                $option
            );

        $operand = $this->createMock(OperandInterface::class);
        $operand
            ->expects($this->once())
            ->method('getName')
            ->willReturn('name');

        $definition
            ->expects($this->exactly(2))
            ->method('getOperand')
            ->withConsecutive(
                [0],
                [1]
            )
            ->willReturnOnConsecutiveCalls(
                $operand,
                $this->throwException($operandNotFound)
            );

        /**
         * @var DefinitionInterface $definition
         */
        $parser = new PosixParser();
        $result = $parser->parse($definition, [
            '-xf',
            '-fab',
            'John Doe',
            '--help',
            '--quite',
            'Jane Doe',
        ], false);

        $this->assertInstanceOf(ParseResultInterface::class, $result);
        if ($result instanceof ParseResultInterface) {
            $this->assertSame([
                'force' => 1,
                'name' => 'John Doe',
                'quite' => true,
            ], $result->getParsed());

            $this->assertSame([
                '-xf',
                '-ab',
                '--help',
                'Jane Doe',
            ], $result->getRemaining());
        }
    }

    /**
     * @covers                   \ExtendsFramework\Console\Parser\Posix\PosixParser::parse()
     * @covers                   \ExtendsFramework\Console\Parser\Posix\PosixParser::parseArguments()
     * @covers                   \ExtendsFramework\Console\Parser\Posix\PosixParser::getOperand()
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
     * @covers            \ExtendsFramework\Console\Parser\Posix\PosixParser::parse()
     * @covers            \ExtendsFramework\Console\Parser\Posix\PosixParser::parseArguments()
     * @covers            \ExtendsFramework\Console\Parser\Posix\PosixParser::getOperand()
     * @expectedException \ExtendsFramework\Console\Definition\Exception\OperandNotFound
     */
    public function testCanNotParseUnknownOperand(): void
    {
        /**
         * @var OperandNotFound $exception
         */
        $exception = $this->createMock(OperandNotFound::class);

        $definition = $this->createMock(DefinitionInterface::class);
        $definition
            ->expects($this->once())
            ->method('getOperand')
            ->with(0)
            ->willThrowException($exception);

        /**
         * @var DefinitionInterface $definition
         */
        $parser = new PosixParser();
        $parser->parse($definition, [
            'John Doe',
        ]);
    }

    /**
     * @covers            \ExtendsFramework\Console\Parser\Posix\PosixParser::parse()
     * @covers            \ExtendsFramework\Console\Parser\Posix\PosixParser::parseArguments()
     * @covers            \ExtendsFramework\Console\Parser\Posix\PosixParser::getOption()
     * @expectedException \ExtendsFramework\Console\Definition\Exception\OptionNotFound
     */
    public function testCanNotParseUnknownOption(): void
    {
        /**
         * @var OptionNotFound $exception
         */
        $exception = $this->createMock(OptionNotFound::class);

        $definition = $this->createMock(DefinitionInterface::class);
        $definition
            ->expects($this->once())
            ->method('getOption')
            ->with('x')
            ->willThrowException($exception);

        /**
         * @var DefinitionInterface $definition
         */
        $parser = new PosixParser();
        $parser->parse($definition, [
            '-x',
        ]);
    }

    /**
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::parse()
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::parseArguments()
     * @covers \ExtendsFramework\Console\Parser\Posix\PosixParser::getOperand()
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
        $result = $parser->parse($definition, [
            '--',
            '-John',
            '--Doe',
        ]);

        $this->assertInstanceOf(ParseResultInterface::class, $result);
        if ($result instanceof ParseResultInterface) {
            $this->assertSame([
                'first' => '-John',
                'last' => '--Doe',
            ], $result->getParsed());
        }
    }
}
