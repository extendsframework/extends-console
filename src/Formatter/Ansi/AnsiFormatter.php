<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Ansi;

use ExtendsFramework\Console\Formatter\Ansi\Exception\InvalidColorName;
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
     * Color mapping.
     *
     * Value is foreground color, background color is an increase of ten.
     *
     * @var array
     */
    protected $mapping = [
        FormatterInterface::COLOR_DEFAULT => 39,
        FormatterInterface::COLOR_BLACK => 30,
        FormatterInterface::COLOR_RED => 31,
        FormatterInterface::COLOR_GREEN => 32,
        FormatterInterface::COLOR_YELLOW => 33,
        FormatterInterface::COLOR_BLUE => 34,
        FormatterInterface::COLOR_MAGENTA => 35,
        FormatterInterface::COLOR_CYAN => 36,
        FormatterInterface::COLOR_LIGHT_GRAY => 37,
        FormatterInterface::COLOR_DARK_GRAY => 90,
        FormatterInterface::COLOR_LIGHT_RED => 91,
        FormatterInterface::COLOR_LIGHT_GREEN => 92,
        FormatterInterface::COLOR_LIGHT_YELLOW => 93,
        FormatterInterface::COLOR_LIGHT_BLUE => 94,
        FormatterInterface::COLOR_LIGHT_MAGENTA => 95,
        FormatterInterface::COLOR_LIGHT_CYAN => 96,
        FormatterInterface::COLOR_WHITE => 97,
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
    public function setForeground(string $color): FormatterInterface
    {
        $this->foreground = $this->getColorCode($color);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setBackground(string $color): FormatterInterface
    {
        $this->background = $this->getColorCode($color, true);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setBold(bool $flag = null): FormatterInterface
    {
        return $this->setFormat(1, $flag);
    }

    /**
     * @inheritDoc
     */
    public function setDim(bool $flag = null): FormatterInterface
    {
        return $this->setFormat(2, $flag);
    }

    /**
     * @inheritDoc
     */
    public function setUnderline(bool $flag = null): FormatterInterface
    {
        return $this->setFormat(4, $flag);
    }

    /**
     * @inheritDoc
     */
    public function setBlink(bool $flag = null): FormatterInterface
    {
        return $this->setFormat(5, $flag);
    }

    /**
     * @inheritDoc
     */
    public function setReverse(bool $flag = null): FormatterInterface
    {
        return $this->setFormat(7, $flag);
    }

    /**
     * @inheritDoc
     */
    public function setHidden(bool $flag = null): FormatterInterface
    {
        return $this->setFormat(8, $flag);
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
    public function create(string $text): string
    {
        $format = 0;
        if (empty($this->format) === false) {
            $format = implode(';', $this->format);
        }

        if (is_int($this->width) === true) {
            $text = str_pad(substr($text, 0, $this->width), $this->width);
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
     * Get code for $color name.
     *
     * @param string    $color
     * @param bool|null $background
     * @return int
     * @throws InvalidColorName
     */
    protected function getColorCode(string $color, bool $background = null): int
    {
        if (array_key_exists($color, $this->mapping) === false) {
            throw new InvalidColorName($color);
        }

        $code = $this->mapping[$color];
        if ($background === true) {
            $code += 10;
        }

        return $code;
    }

    /**
     * Add or remove format.
     *
     * When $flag is true, format will be added, else removed.
     *
     * @param int       $code
     * @param bool|null $flag
     * @return FormatterInterface
     */
    protected function setFormat(int $code, bool $flag = null): FormatterInterface
    {
        if ($flag ?? true) {
            $this->format = array_merge($this->format, [$code]);
        } else {
            $this->format = array_diff($this->format, [$code]);
        }

        return $this;
    }
}
