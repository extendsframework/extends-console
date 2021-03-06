<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Input\Posix;

use PHPUnit\Framework\TestCase;

class PosixInputTest extends TestCase
{
    /**
     * Line.
     *
     * Test that line ('Hello world! How are you doing?') can be read from input and is returned.
     *
     * @covers \ExtendsFramework\Console\Input\Posix\PosixInput::line()
     */
    public function testLine(): void
    {
        Buffer::set('Hello world! How are you doing?');

        $input = new PosixInput();
        $line = $input->line();

        $this->assertEquals('Hello world! How are you doing?', $line);
    }

    /**
     * Line with length.
     *
     * Test that line ('Hello world!  How are you doing?') with max length (13) can be read from input and is returned
     * as shortened text ('Hello world!').
     *
     * @covers \ExtendsFramework\Console\Input\Posix\PosixInput::line()
     */
    public function testLineWithLength(): void
    {
        Buffer::set('Hello world! How are you doing?');

        $input = new PosixInput();
        $line = $input->line(13);

        $this->assertEquals('Hello world!', $line);
    }

    /**
     * Line with return.
     *
     * Test that null will be returned on newline.
     *
     * @covers \ExtendsFramework\Console\Input\Posix\PosixInput::line()
     */
    public function testLineWithReturn(): void
    {
        Buffer::set("\n\r");

        $input = new PosixInput();
        $character = $input->line();

        $this->assertNull($character);
    }

    /**
     * Character.
     *
     * Test that character ('b') can be read from input and is returned.
     *
     * @covers \ExtendsFramework\Console\Input\Posix\PosixInput::character()
     */
    public function testCharacter(): void
    {
        Buffer::set('b');

        $input = new PosixInput();
        $character = $input->character();

        $this->assertEquals('b', $character);
    }

    /**
     * Character with return.
     *
     * Test that null will be returned on newline.
     *
     * @covers \ExtendsFramework\Console\Input\Posix\PosixInput::character()
     */
    public function testCharacterWithReturn(): void
    {
        Buffer::set("\r\n");

        $input = new PosixInput();
        $character = $input->character();

        $this->assertNull($character);
    }

    /**
     * Allowed character.
     *
     * Test that only the allowed character ('a') is read and ('b') is ignored.
     *
     * @covers \ExtendsFramework\Console\Input\Posix\PosixInput::character()
     */
    public function testAllowedCharacter(): void
    {
        $input = new PosixInput();

        Buffer::set('a');
        $first = $input->character('b');

        Buffer::set('a');
        $second = $input->character('a');

        $this->assertNull($first);
        $this->assertEquals('a', $second);
    }
}

/**
 * @return string
 */
function fgets(): string
{
    $buffer = Buffer::get();

    $length = func_get_arg(1);
    if ($length) {
        $buffer = substr($buffer, 0, $length - 1);
    }

    return $buffer;
}

/**
 * @return string
 */
function fgetc(): string
{
    return Buffer::get();
}
