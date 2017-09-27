<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Output\Posix;

use ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter;
use ExtendsFramework\Console\Formatter\FormatterInterface;
use ExtendsFramework\Console\Output\OutputInterface;
use PHPUnit\Framework\TestCase;

class PosixOutputTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::__construct()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::text()
     */
    public function testCanWriteTextToOutput(): void
    {
        Buffer::reset();

        $output = new PosixOutput();
        $output->text('Hello world!');

        $text = Buffer::get();

        static::assertEquals('Hello world!', $text);
    }

    /**
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::__construct()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::text()
     */
    public function testCanWriteFormattedTextToOutput(): void
    {
        Buffer::reset();

        $output = new PosixOutput();
        $output->text('1234567890', $output->getFormatter()->setFixedWidth(5));

        $text = Buffer::get();

        static::assertContains('12345', $text);
        static::assertNotContains('67890', $text);
    }

    /**
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::__construct()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::line()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::newLine()
     */
    public function testCanWriteLineToOutput(): void
    {
        Buffer::reset();

        $output = new PosixOutput();
        $output->line('Hello world!');

        $text = Buffer::get();

        static::assertEquals('Hello world!' . "\n\r", $text);
    }

    /**
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::__construct()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::newLine()
     */
    public function testCanWriteNewLineToOutput(): void
    {
        Buffer::reset();

        $output = new PosixOutput();
        $output->newLine();

        $text = Buffer::get();

        static::assertEquals("\n\r", $text);
    }

    /**
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::__construct()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::line()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::newLine()
     */
    public function testCanWriteMultipleLinesToOutput(): void
    {
        Buffer::reset();

        $output = new PosixOutput();
        $output->line('Foo', 'Bar', 'Baz');

        $text = Buffer::get();

        static::assertEquals('Foo' . "\n\r" . 'Bar' . "\n\r" . 'Baz' . "\n\r", $text);
    }

    /**
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::__construct()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::clear()
     */
    public function testCanClearOutput()
    {
        Buffer::reset();

        $output = new PosixOutput();
        $instance = $output->clear();

        static::assertInstanceOf(OutputInterface::class, $instance);
    }

    /**
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::__construct()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::getColumns()
     */
    public function testCanGetColumns(): void
    {
        Buffer::reset();
        Buffer::set('80');

        $output = new PosixOutput();
        $columns = $output->getColumns();

        static::assertSame(80, $columns);
    }

    /**
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::__construct()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::getLines()
     */
    public function testCanGetLines(): void
    {
        Buffer::reset();
        Buffer::set('120');

        $output = new PosixOutput();
        $lines = $output->getLines();

        static::assertSame(120, $lines);
    }

    /**
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::__construct()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::getFormatter()
     */
    public function testCanGetDefaultFormatter(): void
    {
        $output = new PosixOutput();
        $formatter = $output->getFormatter();

        static::assertInstanceOf(AnsiFormatter::class, $formatter);
    }

    /**
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::__construct()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::getFormatter()
     */
    public function testCanGetCustomFormatter(): void
    {
        $formatter = $this->createMock(FormatterInterface::class);

        /**
         * @var FormatterInterface $formatter
         */
        $output = new PosixOutput($formatter);

        static::assertSame($formatter, $output->getFormatter());
    }
}

class Buffer
{
    protected static $value;

    public static function get(): string
    {
        return static::$value;
    }

    public static function set(string $value): void
    {
        static::$value .= $value;
    }

    public static function reset(): void
    {
        static::$value = null;
    }
}

function fwrite(): void
{
    Buffer::set(func_get_arg(1));
}

function exec(): string
{
    return Buffer::get();
}

function system(): void
{
}
