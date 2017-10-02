<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Ansi;

use ExtendsFramework\Console\Formatter\Ansi\Exception\ColorNotSupported;
use ExtendsFramework\Console\Formatter\Ansi\Exception\FormatNotSupported;
use ExtendsFramework\Console\Formatter\Color\Black\Black;
use ExtendsFramework\Console\Formatter\Color\Blue\Blue;
use ExtendsFramework\Console\Formatter\Color\ColorInterface;
use ExtendsFramework\Console\Formatter\Color\Cyan\Cyan;
use ExtendsFramework\Console\Formatter\Color\DarkGray\DarkGray;
use ExtendsFramework\Console\Formatter\Color\Green\Green;
use ExtendsFramework\Console\Formatter\Color\LightBlue\LightBlue;
use ExtendsFramework\Console\Formatter\Color\LightCyan\LightCyan;
use ExtendsFramework\Console\Formatter\Color\LightGray\LightGray;
use ExtendsFramework\Console\Formatter\Color\LightGreen\LightGreen;
use ExtendsFramework\Console\Formatter\Color\LightMagenta\LightMagenta;
use ExtendsFramework\Console\Formatter\Color\LightRed\LightRed;
use ExtendsFramework\Console\Formatter\Color\LightYellow\LightYellow;
use ExtendsFramework\Console\Formatter\Color\Magenta\Magenta;
use ExtendsFramework\Console\Formatter\Color\Red\Red;
use ExtendsFramework\Console\Formatter\Color\White\White;
use ExtendsFramework\Console\Formatter\Color\Yellow\Yellow;
use ExtendsFramework\Console\Formatter\Format\Blink\Blink;
use ExtendsFramework\Console\Formatter\Format\Bold\Bold;
use ExtendsFramework\Console\Formatter\Format\Dim\Dim;
use ExtendsFramework\Console\Formatter\Format\FormatInterface;
use ExtendsFramework\Console\Formatter\Format\Hidden\Hidden;
use ExtendsFramework\Console\Formatter\Format\Reverse\Reverse;
use ExtendsFramework\Console\Formatter\Format\Underlined\Underlined;
use ExtendsFramework\Console\Formatter\FormatterInterface;

class AnsiFormatter implements FormatterInterface
{
    /**
     * Text foreground color.
     *
     * @var int
     */
    protected $foreground;

    /**
     * Text background color.
     *
     * @var int
     */
    protected $background;

    /**
     * Text format.
     *
     * @var array
     */
    protected $format;

    /**
     * Maximum text width.
     *
     * @var int
     */
    protected $width;

    /**
     * Text indent.
     *
     * @var int
     */
    protected $indent;

    /**
     * Color mapping.
     *
     * @var int[]
     */
    protected $colors = [
        Black::NAME => 30,
        Red::NAME => 31,
        Green::NAME => 32,
        Yellow::NAME => 33,
        Blue::NAME => 34,
        Magenta::NAME => 35,
        Cyan::NAME => 36,
        LightGray::NAME => 37,
        DarkGray::NAME => 90,
        LightRed::NAME => 91,
        LightGreen::NAME => 92,
        LightYellow::NAME => 93,
        LightBlue::NAME => 94,
        LightMagenta::NAME => 95,
        LightCyan::NAME => 96,
        White::NAME => 97,
    ];

    /**
     * Format mapping.
     *
     * @var int[]
     */
    protected $formats = [
        Bold::NAME => 1,
        Dim::NAME => 2,
        Underlined::NAME => 4,
        Blink::NAME => 5,
        Reverse::NAME => 7,
        Hidden::NAME => 8,
    ];

    /**
     * Set default values for builder.
     */
    public function __construct()
    {
        $this->resetBuilder();
    }

    /**
     * @inheritDoc
     */
    public function setForeground(ColorInterface $color): FormatterInterface
    {
        return $this->setColor($color);
    }

    /**
     * @inheritDoc
     */
    public function setBackground(ColorInterface $color): FormatterInterface
    {
        return $this->setColor($color, true);
    }

    /**
     * @inheritDoc
     */
    public function addFormat(FormatInterface $format, bool $remove = null): FormatterInterface
    {
        return $this->setFormat($format);
    }

    /**
     * @inheritDoc
     */
    public function removeFormat(FormatInterface $format): FormatterInterface
    {
        return $this->setFormat($format, true);
    }

    /**
     * @inheritDoc
     */
    public function setFixedWidth(int $length = null): FormatterInterface
    {
        $this->width = $length;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setTextIndent(int $length = null): FormatterInterface
    {
        $this->indent = $length;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function create(string $text): string
    {
        $format = 0;
        if (empty($this->format) === false) {
            $format = implode(';', $this->format);
        }

        if (is_int($this->width) === true) {
            $text = str_pad(substr($text, 0, $this->width), $this->width);
        }

        if (is_int($this->indent) === true) {
            $text = str_repeat(' ', $this->indent) . $text;
        }

        $formatted = sprintf(
            "\e[%s;%d;%dm%s\e[0m",
            $format,
            $this->foreground,
            $this->background,
            $text
        );

        $this->resetBuilder();

        return $formatted;
    }

    /**
     * Reset builder with default values.
     */
    protected function resetBuilder(): void
    {
        $this->foreground = 39;
        $this->background = 49;
        $this->format = [];
        $this->width = null;
    }

    /**
     * Set $format for text.
     *
     * When $remove is true, format will be removed. An exception will be thrown when $format is unknown.
     *
     * @param FormatInterface $format
     * @param bool|null       $remove
     * @return FormatterInterface
     * @throws FormatNotSupported
     */
    protected function setFormat(FormatInterface $format, bool $remove = null): FormatterInterface
    {
        $name = $format->getName();
        if (array_key_exists($name, $this->formats) === false) {
            throw new FormatNotSupported($format);
        }

        $code = $this->formats[$name];
        if ($remove === true) {
            $this->format = array_diff($this->format, [$code]);
        } else {
            $this->format = array_merge($this->format, [$code]);
        }

        return $this;
    }

    /**
     * Set color $code for foreground or background.
     *
     * An exception will be thrown when $color is unknown.
     *
     * @param ColorInterface $color
     * @param bool|null      $background
     * @return FormatterInterface
     * @throws ColorNotSupported
     */
    protected function setColor(ColorInterface $color, bool $background = null): FormatterInterface
    {
        $name = $color->getName();
        if (array_key_exists($name, $this->colors) === false) {
            throw new ColorNotSupported($color);
        }

        if ($background === true) {
            $this->background = $this->colors[$name] + 10;
        } else {
            $this->foreground = $this->colors[$name];
        }

        return $this;
    }
}
