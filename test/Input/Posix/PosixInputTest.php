<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Input\Posix;

use PHPUnit\Framework\TestCase;

class PosixInputTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Input\Posix\PosixInput::__construct()
     * @covers \ExtendsFramework\Console\Input\Posix\PosixInput::line()
     */
    public function testCanReadLineFromStream(): void
    {
        $stream = fopen('php://memory', 'w+');
        fwrite($stream, 'Hello world! How are you doing?');

        $input = new PosixInput($stream);
        $line = $input->line();

        static::assertEquals('Hello world! How are you doing?', $line);
    }

    /**
     * @covers \ExtendsFramework\Console\Input\Posix\PosixInput::__construct()
     * @covers \ExtendsFramework\Console\Input\Posix\PosixInput::line()
     */
    public function testCanReadLineFromStreamWithLength(): void
    {
        $stream = fopen('php://memory', 'w+');
        fwrite($stream, 'Hello world! How are you doing?');

        $input = new PosixInput($stream);
        $line = $input->line(13);

        static::assertEquals('Hello world!', $line);
    }

    /**
     * @covers \ExtendsFramework\Console\Input\Posix\PosixInput::__construct()
     * @covers \ExtendsFramework\Console\Input\Posix\PosixInput::character()
     */
    public function testCanReadCharacterFromStream(): void
    {
        $stream = fopen('php://memory', 'w+');
        fwrite($stream, 'bac');

        $input = new PosixInput($stream);
        $character = $input->character();

        static::assertEquals('b', $character);
    }

    /**
     * @covers \ExtendsFramework\Console\Input\Posix\PosixInput::__construct()
     * @covers \ExtendsFramework\Console\Input\Posix\PosixInput::character()
     */
    public function testCanReadCharacterFromStreamWithAllowed(): void
    {
        $stream = fopen('php://memory', 'w+');
        fwrite($stream, 'bac');

        $input = new PosixInput($stream);
        $character = $input->character('a');

        static::assertEquals('a', $character);
    }

    /**
     * @covers                   \ExtendsFramework\Console\Input\Posix\PosixInput::__construct()
     * @covers                   \ExtendsFramework\Console\Input\Posix\Exception\InvalidStreamType::__construct()
     * @expectedException        \ExtendsFramework\Console\Input\Posix\Exception\InvalidStreamType
     * @expectedExceptionMessage Resource must be of type stream, got "curl".
     */
    public function testCanNotConstructWithInvalidResource(): void
    {
        new PosixInput(curl_init());
    }

    /**
     * @covers                   \ExtendsFramework\Console\Input\Posix\PosixInput::__construct()
     * @covers                   \ExtendsFramework\Console\Input\Posix\PosixInput::line()
     * @covers                   \ExtendsFramework\Console\Input\Posix\Exception\StreamReadFailed::__construct()
     * @expectedException        \ExtendsFramework\Console\Input\Posix\Exception\StreamReadFailed
     * @expectedExceptionMessage Failed to read from stream.
     */
    public function testCanNotReadFromEmptyStream(): void
    {
        $stream = fopen('php://memory', 'w+');
        $input = new PosixInput($stream);
        $input->line(13);
    }
}
