<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Output\Adapter;

use ExtendsFramework\Console\Output\Adapter\Stream\StreamAdapter;
use PHPUnit\Framework\TestCase;

class StreamAdapterTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Output\Adapter\Stream\StreamAdapter::__construct()
     * @covers \ExtendsFramework\Console\Output\Adapter\Stream\StreamAdapter::write()
     */
    public function testCanWriteTextToStream(): void
    {
        $stream = fopen('php://memory', 'r+');
        $adapter = new StreamAdapter($stream);
        $adapter->write('Hello world!');

        $this->assertSame('Hello world!', stream_get_contents($stream, -1, 0));
    }

    /**
     * @covers                   \ExtendsFramework\Console\Output\Adapter\Stream\StreamAdapter::__construct()
     * @covers                   \ExtendsFramework\Console\Output\Adapter\Stream\Exception\InvalidResourceType::__construct()
     * @expectedException        \ExtendsFramework\Console\Output\Adapter\Stream\Exception\InvalidResourceType
     * @expectedExceptionMessage Output stream must be a resource, got "unknown type".
     */
    public function testCanNotConstructWithInvalidStream(): void
    {
        $stream = fopen('php://memory', 'r');
        fclose($stream);

        new StreamAdapter($stream);
    }

    /**
     * @covers                   \ExtendsFramework\Console\Output\Adapter\Stream\StreamAdapter::__construct()
     * @covers                   \ExtendsFramework\Console\Output\Adapter\Stream\StreamAdapter::write()
     * @covers                   \ExtendsFramework\Console\Output\Adapter\Stream\Exception\StreamWriteFailed::__construct()
     * @expectedException        \ExtendsFramework\Console\Output\Adapter\Stream\Exception\StreamWriteFailed
     * @expectedExceptionMessage Failed to write "Hello world!" to stream, got "fwrite(): supplied resource is not a valid stream resource".
     */
    public function testCanNotWriteTextToClosedStream(): void
    {
        $stream = fopen('php://memory', 'r+');
        $adapter = new StreamAdapter($stream);
        fclose($stream);

        $adapter->write('Hello world!');
    }
}
