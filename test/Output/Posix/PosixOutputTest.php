<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Output\Posix;

use ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter;
use PHPUnit\Framework\TestCase;

class PosixOutputTest extends TestCase
{
    /**
     * Text.
     *
     * Test that text ('Hello world!') will be sent to output.
     *
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::__construct()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::text()
     */
    public function testText(): void
    {
        Buffer::reset();

        $output = new PosixOutput();
        $output->text('Hello world!');

        $text = Buffer::get();

        $this->assertEquals('Hello world!', $text);
    }

    /**
     * Formatted text.
     *
     * Text that text ('1234567890') with format (fixed with of 5) will be sent to output ('12345').
     *
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::__construct()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::text()
     */
    public function testFormattedText(): void
    {
        Buffer::reset();

        $output = new PosixOutput();
        $output->text('1234567890', $output->getFormatter()
            ->setFixedWidth(5));

        $text = Buffer::get();

        $this->assertStringContainsString('12345', $text);
        $this->assertStringNotContainsString('67890', $text);
    }

    /**
     * Line.
     *
     * Test that text ('Hello world!') will be sent to output with newline character.
     *
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::__construct()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::line()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::text()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::newLine()
     */
    public function testLine(): void
    {
        Buffer::reset();

        $output = new PosixOutput();
        $output->line('Hello world!');

        $text = Buffer::get();

        $this->assertEquals('Hello world!' . "\n\r", $text);
    }

    /**
     * New line.
     *
     * Test that new line ("\n\r") will be sent to output.
     *
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::__construct()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::newLine()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::text()
     */
    public function testCanWriteNewLineToOutput(): void
    {
        Buffer::reset();

        $output = new PosixOutput();
        $output->newLine();

        $text = Buffer::get();

        $this->assertEquals("\n\r", $text);
    }

    /**
     * Clear output.
     *
     * Test that output can be cleared.
     *
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::__construct()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::clear()
     */
    public function testClearOutput(): void
    {
        Buffer::reset();

        $output = new PosixOutput();
        $instance = $output->clear();

        $this->assertIsObject($instance);
    }

    /**
     * Get columns.
     *
     * Test that columns (80) will be returned.
     *
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::__construct()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::getColumns()
     */
    public function testGetColumns(): void
    {
        Buffer::reset();
        Buffer::set('80');

        $output = new PosixOutput();
        $columns = $output->getColumns();

        $this->assertSame(80, $columns);
    }

    /**
     * Get lines.
     *
     * Test that lines (120) will be returned.
     *
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::__construct()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::getLines()
     */
    public function testGetLines(): void
    {
        Buffer::reset();
        Buffer::set('120');

        $output = new PosixOutput();
        $lines = $output->getLines();

        $this->assertSame(120, $lines);
    }

    /**
     * Get formatter.
     *
     * Test that the default formatter (AnsiFormatter) will be returned.
     *
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::__construct()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::getFormatter()
     */
    public function testGetFormatter(): void
    {
        $output = new PosixOutput();
        $formatter = $output->getFormatter();

        $this->assertInstanceOf(AnsiFormatter::class, $formatter);
    }

    /**
     * Higher verbosity.
     *
     * Test that verbosity (3) can be set and still output text with lower verbosity (2).
     *
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::__construct()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::setVerbosity()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::text()
     */
    public function testHigherVerbosity(): void
    {
        Buffer::reset();

        $output = new PosixOutput();
        $output
            ->setVerbosity(3)
            ->text('Hello world!', null, 2);

        $text = Buffer::get();

        $this->assertEquals('Hello world!', $text);
    }

    /**
     * Higher verbosity.
     *
     * Test that verbosity (2) can be set and don't output text with higher verbosity (3).
     *
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::__construct()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::setVerbosity()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::text()
     */
    public function testLowerVerbosity(): void
    {
        Buffer::reset();

        $output = new PosixOutput();
        $output
            ->setVerbosity(2)
            ->text('Hello world!', null, 3);

        $text = Buffer::get();

        $this->assertNull($text);
    }
}

function fwrite(): void
{
    Buffer::set(func_get_arg(1));
}

/**
 * @return string
 */
function exec(): string
{
    return Buffer::get();
}

function system(): void
{
}
