<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Output\Posix;

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
     * @covers \ExtendsFramework\Console\Output\Posix\PosixOutput::line()
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
