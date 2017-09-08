<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Input\Stream;

use PHPUnit\Framework\TestCase;

class StreamInputTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Input\Stream\StreamInput::__construct()
     * @covers \ExtendsFramework\Console\Input\Stream\StreamInput::line()
     */
    public function testCanReadLineFromStream(): void
    {
        $stream = fopen('php://memory', 'w+');
        fwrite($stream, 'Hello world! How are you doing?');

        $input = new StreamInput($stream);
        $line = $input->line();

        static::assertEquals('Hello world! How are you doing?', $line);
    }

    /**
     * @covers \ExtendsFramework\Console\Input\Stream\StreamInput::__construct()
     * @covers \ExtendsFramework\Console\Input\Stream\StreamInput::line()
     */
    public function testCanReadLineFromStreamWithLength(): void
    {
        $stream = fopen('php://memory', 'w+');
        fwrite($stream, 'Hello world! How are you doing?');

        $input = new StreamInput($stream);
        $line = $input->line(13);

        static::assertEquals('Hello world!', $line);
    }

    /**
     * @covers \ExtendsFramework\Console\Input\Stream\StreamInput::__construct()
     * @covers \ExtendsFramework\Console\Input\Stream\StreamInput::character()
     */
    public function testCanReadCharacterFromStream(): void
    {
        $stream = fopen('php://memory', 'w+');
        fwrite($stream, 'bac');

        $input = new StreamInput($stream);
        $character = $input->character();

        static::assertEquals('b', $character);
    }

    /**
     * @covers \ExtendsFramework\Console\Input\Stream\StreamInput::__construct()
     * @covers \ExtendsFramework\Console\Input\Stream\StreamInput::character()
     */
    public function testCanReadCharacterFromStreamWithAllowed(): void
    {
        $stream = fopen('php://memory', 'w+');
        fwrite($stream, 'bac');

        $input = new StreamInput($stream);
        $character = $input->character('a');

        static::assertEquals('a', $character);
    }

    /**
     * @covers                   \ExtendsFramework\Console\Input\Stream\StreamInput::__construct()
     * @covers                   \ExtendsFramework\Console\Input\Stream\Exception\InvalidStreamType::__construct()
     * @expectedException        \ExtendsFramework\Console\Input\Stream\Exception\InvalidStreamType
     * @expectedExceptionMessage Resource must be of type stream, got "curl".
     */
    public function testCanNotConstructWithInvalidResource(): void
    {
        new StreamInput(curl_init());
    }

    /**
     * @covers                   \ExtendsFramework\Console\Input\Stream\StreamInput::__construct()
     * @covers                   \ExtendsFramework\Console\Input\Stream\StreamInput::line()
     * @covers                   \ExtendsFramework\Console\Input\Stream\Exception\StreamReadFailed::__construct()
     * @expectedException        \ExtendsFramework\Console\Input\Stream\Exception\StreamReadFailed
     * @expectedExceptionMessage Failed to read from stream.
     */
    public function testCanNotReadFromEmptyStream(): void
    {
        $stream = fopen('php://memory', 'w+');
        $input = new StreamInput($stream);
        $input->line(13);
    }
}
