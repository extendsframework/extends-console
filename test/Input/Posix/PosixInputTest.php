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
     * @covers \ExtendsFramework\Console\Input\Posix\PosixInput::line()
     */
    public function testWillReturnNullOnEmptyLine(): void
    {
        $stream = fopen('php://memory', 'w+');
        fwrite($stream, "\n\r");

        $input = new PosixInput($stream);
        $character = $input->line();

        static::assertNull($character);
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
        fwrite($stream, 'ab');

        $input = new PosixInput($stream);
        $first = $input->character('b');
        $second = $input->character('a');

        static::assertNull($first);
        static::assertEquals('a', $second);
    }

    /**
     * @covers \ExtendsFramework\Console\Input\Posix\PosixInput::__construct()
     * @covers \ExtendsFramework\Console\Input\Posix\PosixInput::character()
     */
    public function testWillReturnNullOnEmptyCharacter(): void
    {
        $stream = fopen('php://memory', 'w+');
        fwrite($stream, "\n\r");

        $input = new PosixInput($stream);
        $character = $input->character();

        static::assertNull($character);
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
    public function testCanNotReadLineFromEmptyStream(): void
    {
        $stream = fopen('php://memory', 'w+');
        $input = new PosixInput($stream);
        $input->line(13);
    }

    /**
     * @covers                   \ExtendsFramework\Console\Input\Posix\PosixInput::__construct()
     * @covers                   \ExtendsFramework\Console\Input\Posix\PosixInput::character()
     * @covers                   \ExtendsFramework\Console\Input\Posix\Exception\StreamReadFailed::__construct()
     * @expectedException        \ExtendsFramework\Console\Input\Posix\Exception\StreamReadFailed
     * @expectedExceptionMessage Failed to read from stream.
     */
    public function testCanNotReadCharacterFromEmptyStream(): void
    {
        $stream = fopen('php://memory', 'w+');
        $input = new PosixInput($stream);
        $input->character();
    }
}
