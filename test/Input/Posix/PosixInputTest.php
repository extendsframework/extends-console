<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Input\Posix;

use PHPUnit\Framework\TestCase;

class PosixInputTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Input\Posix\PosixInput::line()
     */
    public function testCanReadLineFromInput(): void
    {
        Buffer::set('Hello world! How are you doing?');

        $input = new PosixInput();
        $line = $input->line();

        static::assertEquals('Hello world! How are you doing?', $line);
    }

    /**
     * @covers \ExtendsFramework\Console\Input\Posix\PosixInput::line()
     */
    public function testCanReadLineFromInputWithLength(): void
    {
        Buffer::set('Hello world!');

        $input = new PosixInput();
        $line = $input->line(13);

        static::assertEquals('Hello world!', $line);
    }

    /**
     * @covers \ExtendsFramework\Console\Input\Posix\PosixInput::line()
     */
    public function testWillReturnNullOnEmptyLine(): void
    {
        Buffer::set("\n\r");

        $input = new PosixInput();
        $character = $input->line();

        static::assertNull($character);
    }

    /**
     * @covers \ExtendsFramework\Console\Input\Posix\PosixInput::character()
     */
    public function testCanReadCharacterFromInput(): void
    {
        Buffer::set('b');

        $input = new PosixInput();
        $character = $input->character();

        static::assertEquals('b', $character);
    }

    /**
     * @covers \ExtendsFramework\Console\Input\Posix\PosixInput::character()
     */
    public function testCanReadCharacterFromInputWithAllowed(): void
    {

        $input = new PosixInput();

        Buffer::set('a');
        $first = $input->character('b');

        Buffer::set('a');
        $second = $input->character('a');

        static::assertNull($first);
        static::assertEquals('a', $second);
    }

    /**
     * @covers \ExtendsFramework\Console\Input\Posix\PosixInput::character()
     */
    public function testWillReturnNullOnEmptyCharacter(): void
    {
        Buffer::set("\r\n");

        $input = new PosixInput();
        $character = $input->character();

        static::assertNull($character);
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
        static::$value = $value;
    }

    public static function reset(): void
    {
        static::$value = null;
    }
}

function fgets(): string
{
    return Buffer::get();
}

function fgetc(): string
{
    return Buffer::get();
}
