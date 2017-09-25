<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Ansi;

use ExtendsFramework\Console\Formatter\FormatterInterface;
use PHPUnit\Framework\TestCase;

class AnsiFormatterTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::__construct()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::resetBuilder()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setForeground()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::getColorCode()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::create()
     */
    public function testCanSetForegroundColor(): void
    {
        $formatter = new AnsiFormatter();
        $text = $formatter
            ->setForeground(FormatterInterface::COLOR_RED)
            ->create('Hello world!');

        self::assertSame("\e[0;31;49mHello world!\e[0m", $text);
    }

    /**
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::__construct()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::resetBuilder()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setBackground()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::getColorCode()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::create()
     */
    public function testCanSetBackgroundColor(): void
    {
        $formatter = new AnsiFormatter();
        $text = $formatter
            ->setBackground(FormatterInterface::COLOR_RED)
            ->create('Hello world!');

        self::assertSame("\e[0;39;41mHello world!\e[0m", $text);
    }

    /**
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::__construct()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::resetBuilder()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setBold()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setFormat()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::create()
     */
    public function testCanSetBoldFormat(): void
    {
        $formatter = new AnsiFormatter();
        $text = $formatter
            ->setBold()
            ->create('Hello world!');

        self::assertSame("\e[1;39;49mHello world!\e[0m", $text);
    }

    /**
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::__construct()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::resetBuilder()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setDim()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setFormat()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::create()
     */
    public function testCanSetDimFormat(): void
    {
        $formatter = new AnsiFormatter();
        $text = $formatter
            ->setDim()
            ->create('Hello world!');

        self::assertSame("\e[2;39;49mHello world!\e[0m", $text);
    }

    /**
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::__construct()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::resetBuilder()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setUnderline()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setFormat()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::create()
     */
    public function testCanSetUnderlineFormat(): void
    {
        $formatter = new AnsiFormatter();
        $text = $formatter
            ->setUnderline()
            ->create('Hello world!');

        self::assertSame("\e[4;39;49mHello world!\e[0m", $text);
    }

    /**
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::__construct()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::resetBuilder()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setBlink()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setFormat()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::create()
     */
    public function testCanSetBlinkFormat(): void
    {
        $formatter = new AnsiFormatter();
        $text = $formatter
            ->setBlink()
            ->create('Hello world!');

        self::assertSame("\e[5;39;49mHello world!\e[0m", $text);
    }

    /**
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::__construct()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::resetBuilder()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setReverse()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setFormat()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::create()
     */
    public function testCanSetReverseFormat(): void
    {
        $formatter = new AnsiFormatter();
        $text = $formatter
            ->setReverse()
            ->create('Hello world!');

        self::assertSame("\e[7;39;49mHello world!\e[0m", $text);
    }

    /**
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::__construct()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::resetBuilder()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setHidden()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setFormat()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::create()
     */
    public function testCanSetHiddenFormat(): void
    {
        $formatter = new AnsiFormatter();
        $text = $formatter
            ->setHidden()
            ->create('Hello world!');

        self::assertSame("\e[8;39;49mHello world!\e[0m", $text);
    }

    /**
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::__construct()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::resetBuilder()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setFixedWidth()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::create()
     */
    public function testCanSetFixedWidth(): void
    {
        $formatter = new AnsiFormatter();
        $long = $formatter
            ->setFixedWidth(20)
            ->create('Hello world!');

        $short = $formatter
            ->setFixedWidth(5)
            ->create('Hello world!');

        self::assertSame("\e[0;39;49mHello world!        \e[0m", $long);
        self::assertSame("\e[0;39;49mHello\e[0m", $short);
    }

    /**
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::__construct()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::resetBuilder()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setBold()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setDim()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setFormat()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::create()
     */
    public function testCanSetMultipleFormats(): void
    {
        $formatter = new AnsiFormatter();
        $text = $formatter
            ->setBold()
            ->setDim()
            ->create('Hello world!');

        self::assertSame("\e[1;2;39;49mHello world!\e[0m", $text);
    }

    /**
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::__construct()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::resetBuilder()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setBold()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setDim()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setFormat()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::create()
     */
    public function testCanUnsetFormat(): void
    {
        $formatter = new AnsiFormatter();
        $text = $formatter
            ->setBold()
            ->setDim()
            ->setBold(false)
            ->create('Hello world!');

        self::assertSame("\e[2;39;49mHello world!\e[0m", $text);
    }

    /**
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::__construct()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::resetBuilder()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setForeground()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setBold()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setFormat()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::create()
     */
    public function testWillResetBuilderAfterCreation(): void
    {
        $formatter = new AnsiFormatter();
        $formatted = $formatter
            ->setForeground(FormatterInterface::COLOR_RED)
            ->setBold()
            ->create('Hello world!');

        $default = $formatter->create('Hello world!');

        self::assertSame("\e[1;31;49mHello world!\e[0m", $formatted);
        self::assertSame("\e[0;39;49mHello world!\e[0m", $default);
    }

    /**
     * @covers                   \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::__construct()
     * @covers                   \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::resetBuilder()
     * @covers                   \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setForeground()
     * @covers                   \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::getColorCode()
     * @covers                   \ExtendsFramework\Console\Formatter\Ansi\Exception\InvalidColorName::__construct()
     * @expectedException        \ExtendsFramework\Console\Formatter\Ansi\Exception\InvalidColorName
     * @expectedExceptionMessage No color found for name "orange".
     */
    public function testCanNotGetColorCodeForUnknownColor(): void
    {
        $formatter = new AnsiFormatter();
        $formatter->setForeground('orange');
    }
}
