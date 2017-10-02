<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Ansi;

use ExtendsFramework\Console\Formatter\Color\ColorInterface;
use ExtendsFramework\Console\Formatter\Color\Red\Red;
use ExtendsFramework\Console\Formatter\Format\Bold\Bold;
use ExtendsFramework\Console\Formatter\Format\Dim\Dim;
use ExtendsFramework\Console\Formatter\Format\FormatInterface;
use PHPUnit\Framework\TestCase;

class AnsiFormatterTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::__construct()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::resetBuilder()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setForeground()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setColor()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::create()
     */
    public function testCanSetForegroundColor(): void
    {
        $formatter = new AnsiFormatter();
        $text = $formatter
            ->setForeground(new Red())
            ->create('Hello world!');

        self::assertSame("\e[0;31;49mHello world!\e[0m", $text);
    }

    /**
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::__construct()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::resetBuilder()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setBackground()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setColor()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::create()
     */
    public function testCanSetBackgroundColor(): void
    {
        $formatter = new AnsiFormatter();
        $text = $formatter
            ->setBackground(new Red())
            ->create('Hello world!');

        self::assertSame("\e[0;39;41mHello world!\e[0m", $text);
    }

    /**
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::__construct()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::resetBuilder()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::addFormat()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setFormat()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::create()
     */
    public function testCanAddFormat(): void
    {
        $formatter = new AnsiFormatter();
        $text = $formatter
            ->addFormat(new Bold())
            ->create('Hello world!');

        self::assertSame("\e[1;39;49mHello world!\e[0m", $text);
    }

    /**
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::__construct()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::resetBuilder()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::addFormat()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::removeFormat()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setFormat()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::create()
     */
    public function testCanRemoveFormat(): void
    {
        $formatter = new AnsiFormatter();
        $text = $formatter
            ->addFormat(new Bold())
            ->removeFormat(new Bold())
            ->create('Hello world!');

        self::assertSame("\e[0;39;49mHello world!\e[0m", $text);
    }

    /**
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::__construct()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::resetBuilder()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::addFormat()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setFormat()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::create()
     */
    public function testCanAddMultipleFormats(): void
    {
        $formatter = new AnsiFormatter();
        $text = $formatter
            ->addFormat(new Bold())
            ->addFormat(new Dim())
            ->create('Hello world!');

        self::assertSame("\e[1;2;39;49mHello world!\e[0m", $text);
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
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setTextIndent()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::create()
     */
    public function testCanSetTextIndent(): void
    {
        $formatter = new AnsiFormatter();
        $text = $formatter
            ->setTextIndent(4)
            ->create('Hello world!');

        self::assertSame("\e[0;39;49m    Hello world!\e[0m", $text);
    }

    /**
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::__construct()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::resetBuilder()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setForeground()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::addFormat()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setFormat()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::create()
     */
    public function testWillResetBuilderAfterCreation(): void
    {
        $formatter = new AnsiFormatter();
        $formatted = $formatter
            ->setForeground(new Red())
            ->addFormat(new Bold())
            ->create('Hello world!');

        $default = $formatter->create('Hello world!');

        self::assertSame("\e[1;31;49mHello world!\e[0m", $formatted);
        self::assertSame("\e[0;39;49mHello world!\e[0m", $default);
    }

    /**
     * @covers                   \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::__construct()
     * @covers                   \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::resetBuilder()
     * @covers                   \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setForeground()
     * @covers                   \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setColor()
     * @covers                   \ExtendsFramework\Console\Formatter\Ansi\Exception\ColorNotSupported::__construct()
     * @expectedException        \ExtendsFramework\Console\Formatter\Ansi\Exception\ColorNotSupported
     * @expectedExceptionMessage Color "Brown" is not supported.
     */
    public function testCanNotGetColorCodeForUnknownColor(): void
    {
        $color = new class implements ColorInterface
        {
            /**
             * @inheritDoc
             */
            public function getName(): string
            {
                return 'Brown';
            }
        };

        $formatter = new AnsiFormatter();
        $formatter->setForeground($color);
    }

    /**
     * @covers                   \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::__construct()
     * @covers                   \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::resetBuilder()
     * @covers                   \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::addFormat()
     * @covers                   \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setFormat()
     * @covers                   \ExtendsFramework\Console\Formatter\Ansi\Exception\FormatNotSupported::__construct()
     * @expectedException        \ExtendsFramework\Console\Formatter\Ansi\Exception\FormatNotSupported
     * @expectedExceptionMessage Format "StrikeThrough" is not supported.
     */
    public function testCanNotGetColorCodeForUnknownFormat(): void
    {
        $format = new class implements FormatInterface
        {
            /**
             * @inheritDoc
             */
            public function getName(): string
            {
                return 'StrikeThrough';
            }
        };

        $formatter = new AnsiFormatter();
        $formatter->addFormat($format);
    }
}
