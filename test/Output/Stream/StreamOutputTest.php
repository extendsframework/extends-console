<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Output\Stream;

use PHPUnit\Framework\TestCase;

class StreamOutputTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Output\Stream\StreamOutput::__construct()
     * @covers \ExtendsFramework\Console\Output\Stream\StreamOutput::text()
     */
    public function testCanWriteTextToOutput(): void
    {
        $stream = fopen('php://memory', 'x+');

        $output = new StreamOutput($stream);
        $output->text('Hello world!');

        $text = stream_get_contents($stream, 1024, 0);

        static::assertEquals('Hello world!', $text);
    }

    /**
     * @covers \ExtendsFramework\Console\Output\Stream\StreamOutput::__construct()
     * @covers \ExtendsFramework\Console\Output\Stream\StreamOutput::line()
     */
    public function testCanWriteLineToOutput(): void
    {
        $stream = fopen('php://memory', 'x+');

        $output = new StreamOutput($stream);
        $output->line('Hello world!');

        $text = stream_get_contents($stream, 1024, 0);

        static::assertEquals('Hello world!' . "\n\r", $text);
    }

    /**
     * @covers                   \ExtendsFramework\Console\Output\Stream\StreamOutput::__construct()
     * @covers                   \ExtendsFramework\Console\Output\Stream\Exception\InvalidStreamType::__construct()
     * @expectedException        \ExtendsFramework\Console\Output\Stream\Exception\InvalidStreamType
     * @expectedExceptionMessage Resource must be of type stream, got "curl".
     */
    public function testCanNotConstructWithInvalidResource(): void
    {
        new StreamOutput(curl_init());
    }

    /**
     * @covers                   \ExtendsFramework\Console\Output\Stream\StreamOutput::__construct()
     * @covers                   \ExtendsFramework\Console\Output\Stream\StreamOutput::text()
     * @expectedException        \ExtendsFramework\Console\Output\Stream\Exception\StreamWriteFailed
     * @covers                   \ExtendsFramework\Console\Output\Stream\Exception\StreamWriteFailed::__construct()
     * @expectedExceptionMessage Failed to write to stream.
     */
    public function testCanNotWriteToClosedStream(): void
    {
        $stream = fopen('php://memory', 'w+');
        $output = new StreamOutput($stream);
        fclose($stream);

        $output->text('Hello world!');
    }
}
