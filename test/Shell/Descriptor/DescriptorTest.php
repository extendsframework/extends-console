<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Shell\Descriptor;

use Exception;
use ExtendsFramework\Console\Definition\DefinitionInterface;
use ExtendsFramework\Console\Definition\Operand\OperandInterface;
use ExtendsFramework\Console\Definition\Option\OptionInterface;
use ExtendsFramework\Console\Formatter\FormatterInterface;
use ExtendsFramework\Console\Output\OutputInterface;
use ExtendsFramework\Console\Shell\Command\CommandInterface;
use PHPUnit\Framework\TestCase;
use Throwable;

class DescriptorTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Shell\Descriptor\Descriptor::__construct()
     * @covers \ExtendsFramework\Console\Shell\Descriptor\Descriptor::shell()
     */
    public function testCanDescribeShellShort(): void
    {
        $index = 0;

        $output = $this->createMock(OutputInterface::class);
        $output
            ->expects($this->at(++$index))
            ->method('newLine')
            ->willReturnSelf();

        $output
            ->expects($this->at(++$index))
            ->method('line')
            ->with('See \'extends --help\' for more information about available commands and options.')
            ->willReturnSelf();

        $definition = $this->createMock(DefinitionInterface::class);

        /**
         * @var OutputInterface     $output
         * @var DefinitionInterface $definition
         */
        $descriptor = new Descriptor($output, 'Extends Framework Console', 'extends', '0.1');
        $instance = $descriptor->shell($definition, [], true);

        $this->assertSame($descriptor, $instance);
    }

    /**
     * @covers \ExtendsFramework\Console\Shell\Descriptor\Descriptor::__construct()
     * @covers \ExtendsFramework\Console\Shell\Descriptor\Descriptor::shell()
     * @covers \ExtendsFramework\Console\Shell\Descriptor\Descriptor::getOptionNotation()
     */
    public function testCanDescribeShellLong(): void
    {
        $index = 0;

        $output = $this->createMock(OutputInterface::class);
        $output
            ->expects($this->at(++$index))
            ->method('line')
            ->with('Extends Framework Console (version 0.1)')
            ->willReturnSelf();

        $output
            ->expects($this->at(++$index))
            ->method('newLine')
            ->willReturnSelf();

        $output
            ->expects($this->at(++$index))
            ->method('line')
            ->with('Usage:')
            ->willReturnSelf();

        $output
            ->expects($this->at(++$index))
            ->method('newLine')
            ->willReturnSelf();

        $output
            ->expects($this->at(++$index))
            ->method('text')
            ->with(
                'extends',
                $this->isInstanceOf(FormatterInterface::class)
            )
            ->willReturnSelf();

        $output
            ->expects($this->at(++$index))
            ->method('line')
            ->with('<command> [<arguments>] [<options>]')
            ->willReturnSelf();

        $output
            ->expects($this->at(++$index))
            ->method('newLine')
            ->willReturnSelf();

        $output
            ->expects($this->at(++$index))
            ->method('line')
            ->with('Commands:')
            ->willReturnSelf();

        $output
            ->expects($this->at(++$index))
            ->method('newLine')
            ->willReturnSelf();

        $output
            ->expects($this->at(++$index))
            ->method('text')
            ->with(
                'do.task',
                $this->isInstanceOf(FormatterInterface::class)
            )
            ->willReturnSelf();

        $output
            ->expects($this->at(++$index))
            ->method('line')
            ->with('Do some fancy task!')
            ->willReturnSelf();

        $output
            ->expects($this->at(++$index))
            ->method('newLine')
            ->willReturnSelf();

        $output
            ->expects($this->at(++$index))
            ->method('line')
            ->with('Options:')
            ->willReturnSelf();

        $output
            ->expects($this->at(++$index))
            ->method('newLine')
            ->willReturnSelf();

        $output
            ->expects($this->at(++$index))
            ->method('text')
            ->with(
                '-o=|--option=',
                $this->isInstanceOf(FormatterInterface::class)
            )
            ->willReturnSelf();

        $output
            ->expects($this->at(++$index))
            ->method('line')
            ->with('Show help.')
            ->willReturnSelf();

        $output
            ->expects($this->at(++$index))
            ->method('newLine')
            ->willReturnSelf();

        $output
            ->expects($this->at(++$index))
            ->method('line')
            ->with('See \'extends <command> --help\' for more information about a command.')
            ->willReturnSelf();

        $option = $this->createMock(OptionInterface::class);
        $option
            ->expects($this->once())
            ->method('getShort')
            ->willReturn('o');

        $option
            ->expects($this->once())
            ->method('getLong')
            ->willReturn('option');

        $option
            ->expects($this->once())
            ->method('isFlag')
            ->willReturn(false);

        $option
            ->expects($this->once())
            ->method('getDescription')
            ->willReturn('Show help.');

        $definition = $this->createMock(DefinitionInterface::class);
        $definition
            ->expects($this->once())
            ->method('getOptions')
            ->willReturn([
                $option,
            ]);

        $command = $this->createMock(CommandInterface::class);
        $command
            ->expects($this->once())
            ->method('getName')
            ->willReturn('do.task');

        $command
            ->expects($this->once())
            ->method('getDescription')
            ->willReturn('Do some fancy task!');

        /**
         * @var OutputInterface     $output
         * @var DefinitionInterface $definition
         */
        $descriptor = new Descriptor($output, 'Extends Framework Console', 'extends', '0.1');
        $instance = $descriptor->shell($definition, [
            $command,
        ]);

        $this->assertSame($descriptor, $instance);
    }

    /**
     * @covers \ExtendsFramework\Console\Shell\Descriptor\Descriptor::__construct()
     * @covers \ExtendsFramework\Console\Shell\Descriptor\Descriptor::command()
     */
    public function testCanDescribeCommandShort(): void
    {
        $index = 0;

        $output = $this->createMock(OutputInterface::class);
        $output
            ->expects($this->at(++$index))
            ->method('newLine')
            ->willReturnSelf();

        $output
            ->expects($this->at(++$index))
            ->method('line')
            ->with('See \'extends do.task --help\' for more information about the command.')
            ->willReturnSelf();

        $command = $this->createMock(CommandInterface::class);
        $command
            ->expects($this->once())
            ->method('getName')
            ->willReturn('do.task');

        /**
         * @var OutputInterface  $output
         * @var CommandInterface $command
         */
        $descriptor = new Descriptor($output, 'Extends Framework Console', 'extends', '0.1');
        $instance = $descriptor->command($command, true);

        $this->assertSame($descriptor, $instance);
    }

    /**
     * @covers \ExtendsFramework\Console\Shell\Descriptor\Descriptor::__construct()
     * @covers \ExtendsFramework\Console\Shell\Descriptor\Descriptor::command()
     * @covers \ExtendsFramework\Console\Shell\Descriptor\Descriptor::getOptionNotation
     */
    public function testCanDescribeCommandLong(): void
    {
        $index = 0;

        $output = $this->createMock(OutputInterface::class);
        $output
            ->expects($this->at(++$index))
            ->method('line')
            ->with('Extends Framework Console (version 0.1)')
            ->willReturnSelf();

        $output
            ->expects($this->at(++$index))
            ->method('newLine')
            ->willReturnSelf();

        $output
            ->expects($this->at(++$index))
            ->method('line')
            ->with('Usage:')
            ->willReturnSelf();

        $output
            ->expects($this->at(++$index))
            ->method('newLine')
            ->willReturnSelf();

        $output
            ->expects($this->at(++$index))
            ->method('text')
            ->with(
                'extends',
                $this->isInstanceOf(FormatterInterface::class)
            )
            ->willReturnSelf();

        $output
            ->expects($this->at(++$index))
            ->method('text')
            ->with('do.task ')
            ->willReturnSelf();

        $output
            ->expects($this->at(++$index))
            ->method('text')
            ->with('<name> ')
            ->willReturnSelf();

        $output
            ->expects($this->at(++$index))
            ->method('line')
            ->with('[<options>] ')
            ->willReturnSelf();

        $output
            ->expects($this->at(++$index))
            ->method('newLine')
            ->willReturnSelf();

        $output
            ->expects($this->at(++$index))
            ->method('line')
            ->with('Options:')
            ->willReturnSelf();

        $output
            ->expects($this->at(++$index))
            ->method('newLine')
            ->willReturnSelf();

        $output
            ->expects($this->at(++$index))
            ->method('text')
            ->with(
                '-o+|--option+',
                $this->isInstanceOf(FormatterInterface::class)
            )
            ->willReturnSelf();

        $output
            ->expects($this->at(++$index))
            ->method('line')
            ->with('Show option.')
            ->willReturnSelf();

        $output
            ->expects($this->at(++$index))
            ->method('newLine')
            ->willReturnSelf();

        $output
            ->expects($this->at(++$index))
            ->method('line')
            ->with('See \'extends --help\' for more information about this shell and default options.')
            ->willReturnSelf();

        $operand = $this->createMock(OperandInterface::class);
        $operand
            ->expects($this->once())
            ->method('getName')
            ->willReturn('name');

        $option = $this->createMock(OptionInterface::class);
        $option
            ->expects($this->once())
            ->method('getShort')
            ->willReturn('o');

        $option
            ->expects($this->once())
            ->method('getLong')
            ->willReturn('option');

        $option
            ->expects($this->once())
            ->method('isFlag')
            ->willReturn(true);

        $option
            ->expects($this->once())
            ->method('isMultiple')
            ->willReturn(true);

        $option
            ->expects($this->once())
            ->method('getDescription')
            ->willReturn('Show option.');

        $definition = $this->createMock(DefinitionInterface::class);
        $definition
            ->expects($this->once())
            ->method('getOptions')
            ->willReturn([
                $option,
            ]);

        $definition
            ->expects($this->once())
            ->method('getOperands')
            ->willReturn([
                $operand,
            ]);

        $command = $this->createMock(CommandInterface::class);
        $command
            ->expects($this->once())
            ->method('getName')
            ->willReturn('do.task');

        $command
            ->expects($this->once())
            ->method('getDefinition')
            ->willReturn($definition);

        /**
         * @var OutputInterface  $output
         * @var CommandInterface $command
         */
        $descriptor = new Descriptor($output, 'Extends Framework Console', 'extends', '0.1');
        $instance = $descriptor->command($command);

        $this->assertSame($descriptor, $instance);
    }

    /**
     * @covers \ExtendsFramework\Console\Shell\Descriptor\Descriptor::__construct()
     * @covers \ExtendsFramework\Console\Shell\Descriptor\Descriptor::suggest()
     */
    public function testCanDescribeSuggest(): void
    {
        $index = 0;

        $output = $this->createMock(OutputInterface::class);
        $output
            ->expects($this->at(++$index))
            ->method('newLine')
            ->willReturnSelf();

        $output
            ->expects($this->at(++$index))
            ->method('text')
            ->with('Did you mean "')
            ->willReturnSelf();

        $output
            ->expects($this->at(++$index))
            ->method('text')
            ->with(
                'do.task',
                $this->isInstanceOf(FormatterInterface::class)
            )
            ->willReturnSelf();

        $output
            ->expects($this->at(++$index))
            ->method('line')
            ->with('"?')
            ->willReturnSelf();

        $command = $this->createMock(CommandInterface::class);
        $command
            ->expects($this->once())
            ->method('getName')
            ->willReturn('do.task');

        /**
         * @var OutputInterface  $output
         * @var CommandInterface $command
         */
        $descriptor = new Descriptor($output, 'Extends Framework Console', 'extends', '0.1');
        $instance = $descriptor->suggest($command);

        $this->assertSame($descriptor, $instance);
    }

    /**
     * @covers \ExtendsFramework\Console\Shell\Descriptor\Descriptor::__construct()
     * @covers \ExtendsFramework\Console\Shell\Descriptor\Descriptor::exception()
     */
    public function testCanDescribeException(): void
    {
        $index = 0;

        $output = $this->createMock(OutputInterface::class);
        $output
            ->expects($this->at(++$index))
            ->method('line')
            ->with(
                'Random exception message!',
                $this->isInstanceOf(FormatterInterface::class)
            );

        /**
         * @var OutputInterface $output
         * @var Throwable       $exception
         */
        $descriptor = new Descriptor($output, 'Extends Framework Console', 'extends', '0.1');
        $instance = $descriptor->exception(new Exception('Random exception message!'));

        $this->assertSame($descriptor, $instance);
    }
}
