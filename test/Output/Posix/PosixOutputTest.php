<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Output\Posix;

use ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter;
use ExtendsFramework\Console\Formatter\FormatterInterface;
use PHPUnit\Framework\TestCase;

class PosixOutputTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::__construct()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::text()
     */
    public function testCanWriteTextToOutput(): void
    {
        $stream = fopen('php://memory', 'x+');

        $output = new PosixOutput($stream);
        $output->text('Hello world!');

        $text = stream_get_contents($stream, 1024, 0);

        static::assertEquals('Hello world!', $text);
    }

    /**
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::__construct()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::text()
     */
    public function testCanWriteFormattedTextToOutput(): void
    {
        $stream = fopen('php://memory', 'x+');

        $output = new PosixOutput($stream);
        $output->text('1234567890', $output->getFormatter()->setFixedWidth(5));

        $text = stream_get_contents($stream, 1024, 0);

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
        $stream = fopen('php://memory', 'x+');

        $output = new PosixOutput($stream);
        $output->line('Hello world!');

        $text = stream_get_contents($stream, 1024, 0);

        static::assertEquals('Hello world!' . "\n\r", $text);
    }

    /**
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::__construct()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::newLine()
     */
    public function testCanWriteNewLineToOutput(): void
    {
        $stream = fopen('php://memory', 'x+');

        $output = new PosixOutput($stream);
        $output->newLine();

        $text = stream_get_contents($stream, 1024, 0);

        static::assertEquals("\n\r", $text);
    }

    /**
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::__construct()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::line()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::newLine()
     */
    public function testCanWriteMultipleLinesToOutput(): void
    {
        $stream = fopen('php://memory', 'x+');

        $output = new PosixOutput($stream);
        $output->line('Foo', 'Bar', 'Baz');

        $text = stream_get_contents($stream, 1024, 0);

        static::assertEquals('Foo' . "\n\r" . 'Bar' . "\n\r" . 'Baz' . "\n\r", $text);
    }

    /**
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::__construct()
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::getFormatter()
     */
    public function testCanGetDefaultFormatter(): void
    {
        $stream = fopen('php://memory', 'x+');

        $output = new PosixOutput($stream);
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

        $stream = fopen('php://memory', 'x+');

        /**
         * @var FormatterInterface $formatter
         */
        $output = new PosixOutput($stream, $formatter);

        static::assertSame($formatter, $output->getFormatter());
    }

    /**
     * @covers                   \ExtendsFramework\Console\Output\Posix\PosixOutput::__construct()
     * @covers                   \ExtendsFramework\Console\Output\Posix\Exception\InvalidStreamType::__construct()
     * @expectedException        \ExtendsFramework\Console\Output\Posix\Exception\InvalidStreamType
     * @expectedExceptionMessage Resource must be of type stream, got "curl".
     */
    public function testCanNotConstructWithInvalidResource(): void
    {
        new PosixOutput(curl_init());
    }

    /**
     * @covers                   \ExtendsFramework\Console\Output\Posix\PosixOutput::__construct()
     * @covers                   \ExtendsFramework\Console\Output\Posix\PosixOutput::text()
     * @expectedException        \ExtendsFramework\Console\Output\Posix\Exception\StreamWriteFailed
     * @covers                   \ExtendsFramework\Console\Output\Posix\Exception\StreamWriteFailed::__construct()
     * @expectedExceptionMessage Failed to write to stream.
     */
    public function testCanNotWriteToClosedStream(): void
    {
        $stream = fopen('php://memory', 'w+');
        $output = new PosixOutput($stream);
        fclose($stream);

        $output->text('Hello world!');
    }
}
