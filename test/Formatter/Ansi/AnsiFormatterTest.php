<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Ansi;

use ExtendsFramework\Console\Formatter\Ansi\Exception\ColorNotSupported;
use ExtendsFramework\Console\Formatter\Ansi\Exception\FormatNotSupported;
use ExtendsFramework\Console\Formatter\Color\ColorInterface;
use ExtendsFramework\Console\Formatter\Color\Red\Red;
use ExtendsFramework\Console\Formatter\Format\Bold\Bold;
use ExtendsFramework\Console\Formatter\Format\Dim\Dim;
use ExtendsFramework\Console\Formatter\Format\FormatInterface;
use PHPUnit\Framework\TestCase;

class AnsiFormatterTest extends TestCase
{
    /**
     * Foreground color.
     *
     * Test that foreground color can be set and used to create text.
     *
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::__construct()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::resetBuilder()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setForeground()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setColor()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::create()
     */
    public function testForegroundColor(): void
    {
        $formatter = new AnsiFormatter();
        $text = $formatter
            ->setForeground(new Red())
            ->create('Hello world!');

        $this->assertSame("\e[0;31;49mHello world!\e[0m", $text);
    }

    /**
     * Background color.
     *
     * Test that background color can be set and used to create text.
     *
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::__construct()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::resetBuilder()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setBackground()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setColor()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::create()
     */
    public function testBackgroundColor(): void
    {
        $formatter = new AnsiFormatter();
        $text = $formatter
            ->setBackground(new Red())
            ->create('Hello world!');

        $this->assertSame("\e[0;39;41mHello world!\e[0m", $text);
    }

    /**
     * Add format.
     *
     * Test that format can be added and used to create text.
     *
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::__construct()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::resetBuilder()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::addFormat()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setFormat()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::create()
     */
    public function testAddFormat(): void
    {
        $formatter = new AnsiFormatter();
        $text = $formatter
            ->addFormat(new Bold())
            ->create('Hello world!');

        $this->assertSame("\e[1;39;49mHello world!\e[0m", $text);
    }

    /**
     * Remove format.
     *
     * Test that format can be removed and is not used to create text.
     *
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::__construct()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::resetBuilder()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::addFormat()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::removeFormat()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setFormat()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::create()
     */
    public function testRemoveFormat(): void
    {
        $formatter = new AnsiFormatter();
        $text = $formatter
            ->addFormat(new Bold())
            ->removeFormat(new Bold())
            ->create('Hello world!');

        $this->assertSame("\e[0;39;49mHello world!\e[0m", $text);
    }

    /**
     * Add multiple formats.
     *
     * Test that multiple formats can be added and used to create text.
     *
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::__construct()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::resetBuilder()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::addFormat()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setFormat()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::create()
     */
    public function testAddMultipleFormats(): void
    {
        $formatter = new AnsiFormatter();
        $text = $formatter
            ->addFormat(new Bold())
            ->addFormat(new Dim())
            ->create('Hello world!');

        $this->assertSame("\e[1;2;39;49mHello world!\e[0m", $text);
    }

    /**
     * Fixed width.
     *
     * Test that texts fill be fixed to a length of 20 and 5. When text is longer then the fixed with, the text must be
     * truncated.
     *
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::__construct()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::resetBuilder()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setFixedWidth()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::create()
     */
    public function testFixedWidth(): void
    {
        $formatter = new AnsiFormatter();
        $long = $formatter
            ->setFixedWidth(20)
            ->create('Hello world!');

        $short = $formatter
            ->setFixedWidth(5)
            ->create('Hello world!');

        $this->assertSame("\e[0;39;49mHello world!        \e[0m", $long);
        $this->assertSame("\e[0;39;49mHello\e[0m", $short);
    }

    /**
     * Text indent.
     *
     * Test that text can be indented with a length of 4.
     *
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::__construct()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::resetBuilder()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setTextIndent()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::create()
     */
    public function testTextIndent(): void
    {
        $formatter = new AnsiFormatter();
        $text = $formatter
            ->setTextIndent(4)
            ->create('Hello world!');

        $this->assertSame("\e[0;39;49m    Hello world!\e[0m", $text);
    }

    /**
     * Reset.
     *
     * Test that builder will be reset with default values after method create is called.
     *
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::__construct()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::resetBuilder()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setForeground()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::addFormat()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setFormat()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::create()
     */
    public function testReset(): void
    {
        $formatter = new AnsiFormatter();
        $formatted = $formatter
            ->setForeground(new Red())
            ->addFormat(new Bold())
            ->create('Hello world!');

        $default = $formatter->create('Hello world!');

        $this->assertSame("\e[1;31;49mHello world!\e[0m", $formatted);
        $this->assertSame("\e[0;39;49mHello world!\e[0m", $default);
    }

    /**
     * Unknown color.
     *
     * Test that an exception will be thrown when a unknown color is given.
     *
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::__construct()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::resetBuilder()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setForeground()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setColor()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\Exception\ColorNotSupported::__construct()
     */
    public function testUnknownColor(): void
    {
        $this->expectException(ColorNotSupported::class);
        $this->expectExceptionMessage('Color "Brown" is not supported.');

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
     * Unknown format.
     *
     * Test that an exception will be thrown when a unknown format is given.
     *
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::__construct()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::resetBuilder()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::addFormat()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter::setFormat()
     * @covers \ExtendsFramework\Console\Formatter\Ansi\Exception\FormatNotSupported::__construct()
     */
    public function testUnknownFormat(): void
    {
        $this->expectException(FormatNotSupported::class);
        $this->expectExceptionMessage('Format "StrikeThrough" is not supported.');

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
