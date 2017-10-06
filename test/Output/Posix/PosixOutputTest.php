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
     * Text.
     *
     * Test that text ('Hello world!') will be sent to output.
     *
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::text()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::getVerbosity()
     */
    public function testText(): void
    {
        Buffer::reset();

        $output = new PosixOutput();
        $output->text('Hello world!');

        $text = Buffer::get();

        static::assertEquals('Hello world!', $text);
    }

    /**
     * Formatted text.
     *
     * Text that text ('1234567890') with format (fixed with of 5) will be sent to output ('12345').
     *
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::text()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::getVerbosity()
     */
    public function testFormattedText(): void
    {
        Buffer::reset();

        $output = new PosixOutput();
        $output->text('1234567890', $output->getFormatter()->setFixedWidth(5));

        $text = Buffer::get();

        static::assertContains('12345', $text);
        static::assertNotContains('67890', $text);
    }

    /**
     * Line.
     *
     * Test that text ('Hello world!') will be sent to output with newline character.
     *
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::line()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::text()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::getVerbosity()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::newLine()
     */
    public function testLine(): void
    {
        Buffer::reset();

        $output = new PosixOutput();
        $output->line('Hello world!');

        $text = Buffer::get();

        static::assertEquals('Hello world!' . "\n\r", $text);
    }

    /**
     * New line.
     *
     * Test that new line ("\n\r") will be sent to output.
     *
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::newLine()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::text()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::getVerbosity()
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
     * Clear output.
     *
     * Test that output can be cleared.
     *
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::clear()
     */
    public function testClearOutput()
    {
        Buffer::reset();

        $output = new PosixOutput();
        $instance = $output->clear();

        static::assertInstanceOf(OutputInterface::class, $instance);
    }

    /**
     * Get columns.
     *
     * Test that columns (80) will be returned.
     *
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::getColumns()
     */
    public function testGetColumns(): void
    {
        Buffer::reset();
        Buffer::set('80');

        $output = new PosixOutput();
        $columns = $output->getColumns();

        static::assertSame(80, $columns);
    }

    /**
     * Get lines.
     *
     * Test that lines (120) will be returned.
     *
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::getLines()
     */
    public function testGetLines(): void
    {
        Buffer::reset();
        Buffer::set('120');

        $output = new PosixOutput();
        $lines = $output->getLines();

        static::assertSame(120, $lines);
    }

    /**
     * Get formatter.
     *
     * Test that the default formatter (AnsiFormatter) will be returned.
     *
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::getFormatter()
     */
    public function testGetFormatter(): void
    {
        $output = new PosixOutput();
        $formatter = $output->getFormatter();

        static::assertInstanceOf(AnsiFormatter::class, $formatter);
    }

    /**
     * Set formatter.
     *
     * Test that a custom formatter can be set and get.
     *
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::getFormatter()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::setFormatter()
     */
    public function testSetFormatter(): void
    {
        $formatter = $this->createMock(FormatterInterface::class);

        /**
         * @var FormatterInterface $formatter
         */
        $output = new PosixOutput();
        $output->setFormatter($formatter);

        static::assertSame($formatter, $output->getFormatter());
    }

    /**
     * Higher verbosity.
     *
     * Test that verbosity (3) can be set and still output text with lower verbosity (2).
     *
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::setVerbosity()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::text()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::getVerbosity()
     */
    public function testHigherVerbosity(): void
    {
        Buffer::reset();

        $output = new PosixOutput();
        $output
            ->setVerbosity(3)
            ->text('Hello world!', null, 2);

        $text = Buffer::get();

        static::assertEquals('Hello world!', $text);
    }

    /**
     * Higher verbosity.
     *
     * Test that verbosity (2) can be set and don't output text with higher verbosity (3).
     *
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::setVerbosity()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::text()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::getVerbosity()
     */
    public function testLowerVerbosity(): void
    {
        Buffer::reset();

        $output = new PosixOutput();
        $output
            ->setVerbosity(2)
            ->text('Hello world!', null, 3);

        $text = Buffer::get();

        static::assertNull($text);
    }
}

class Buffer
{
    protected static $value;

    public static function get(): ?string
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
