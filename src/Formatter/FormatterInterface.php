<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter;

interface FormatterInterface
{
    /**
     * Default color.
     *
     * @const string
     */
    const COLOR_DEFAULT = 'default';

    /**
     * Black color.
     *
     * @const string
     */
    const COLOR_BLACK = 'black';

    /**
     * Red color.
     *
     * @const string
     */
    const COLOR_RED = 'red';

    /**
     * Green color.
     *
     * @const string
     */
    const COLOR_GREEN = 'green';

    /**
     * Yellow color.
     *
     * @const string
     */
    const COLOR_YELLOW = 'yellow';

    /**
     * Blue color.
     *
     * @const string
     */
    const COLOR_BLUE = 'blue';

    /**
     * Magenta color.
     *
     * @const string
     */
    const COLOR_MAGENTA = 'magenta';

    /**
     * Cyan color.
     *
     * @const string
     */
    const COLOR_CYAN = 'cyan';

    /**
     * Light gray color.
     *
     * @const string
     */
    const COLOR_LIGHT_GRAY = 'light-gray';

    /**
     * Dark gray color.
     *
     * @const string
     */
    const COLOR_DARK_GRAY = 'dark-gray';

    /**
     * Light red color.
     *
     * @const string
     */
    const COLOR_LIGHT_RED = 'light-red';

    /**
     * Light green color.
     *
     * @const string
     */
    const COLOR_LIGHT_GREEN = 'light-green';

    /**
     * Light yellow color.
     *
     * @const string
     */
    const COLOR_LIGHT_YELLOW = 'light-yellow';

    /**
     * Light blue color.
     *
     * @const string
     */
    const COLOR_LIGHT_BLUE = 'light-blue';

    /**
     * Light magenta color.
     *
     * @const string
     */
    const COLOR_LIGHT_MAGENTA = 'light-magenta';

    /**
     * Light cyan color.
     *
     * @const string
     */
    const COLOR_LIGHT_CYAN = 'light-cyan';

    /**
     * White color.
     *
     * @const string
     */
    const COLOR_WHITE = 'white';

    /**
     * Set text foreground color.
     *
     * An exception will be thrown when $color is unknown.
     *
     * @param string $color
     * @return FormatterInterface
     * @throws FormatterException
     */
    public function setForeground(string $color): FormatterInterface;

    /**
     * Set text background color.
     *
     * An exception will be thrown when $color is unknown.
     *
     * @param string $color
     * @return FormatterInterface
     * @throws FormatterException
     */
    public function setBackground(string $color): FormatterInterface;

    /**
     * Set bold text format.
     *
     * @param bool|null $flag
     * @return FormatterInterface
     */
    public function setBold(bool $flag = null): FormatterInterface;

    /**
     * Set dim text format.
     *
     * @param bool|null $flag
     * @return FormatterInterface
     */
    public function setDim(bool $flag = null): FormatterInterface;

    /**
     * Set underline text format.
     *
     * @param bool|null $flag
     * @return FormatterInterface
     */
    public function setUnderline(bool $flag = null): FormatterInterface;

    /**
     * Set blink text format.
     *
     * @param bool|null $flag
     * @return FormatterInterface
     */
    public function setBlink(bool $flag = null): FormatterInterface;

    /**
     * Reverse foreground and background color.
     *
     * @param bool|null $flag
     * @return FormatterInterface
     */
    public function setReverse(bool $flag = null): FormatterInterface;

    /**
     * Set hidden text format.
     *
     * @param bool|null $flag
     * @return FormatterInterface
     */
    public function setHidden(bool $flag = null): FormatterInterface;

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
