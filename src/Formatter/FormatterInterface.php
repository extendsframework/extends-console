<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter;

use ExtendsFramework\Console\Formatter\Color\ColorInterface;
use ExtendsFramework\Console\Formatter\Format\FormatInterface;

interface FormatterInterface
{
    /**
     * Set text foreground color.
     *
     * An exception will be thrown when $color is unknown.
     *
     * @param ColorInterface $color
     * @return FormatterInterface
     * @throws FormatterException
     */
    public function setForeground(ColorInterface $color): FormatterInterface;

    /**
     * Set text background color.
     *
     * An exception will be thrown when $color is unknown.
     *
     * @param ColorInterface $color
     * @return FormatterInterface
     * @throws FormatterException
     */
    public function setBackground(ColorInterface $color): FormatterInterface;

    /**
     * Add $format for text.
     *
     * An exception will be thrown when $format is unknown.
     *
     * @param FormatInterface $format
     * @return FormatterInterface
     * @throws FormatterException
     */
    public function addFormat(FormatInterface $format): FormatterInterface;

    /**
     * Remove $format for text.
     *
     * An exception will be thrown when $format is unknown.
     *
     * @param FormatInterface $format
     * @return FormatterInterface
     * @throws FormatterException
     */
    public function removeFormat(FormatInterface $format): FormatterInterface;

    /**
     * Set fixed width to $length.
     *
     * If text is longer, text will be shortened to $length.
     *
     * @param int|null $length
     * @return FormatterInterface
     */
    public function setFixedWidth(int $length = null): FormatterInterface;

    /**
     * Add format to $text.
     *
     * Formatted text will be returned.
     *
     * @param string $text
     * @return string
     */
    public function create(string $text): string;
}
