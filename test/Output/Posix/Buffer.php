<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Output\Posix;

class Buffer
{
    /**
     * @var string
     */
    protected static $value;

    /**
     * @return string|null
     */
    public static function get(): ?string
    {
        return static::$value;
    }

    /**
     * @param string $value
     */
    public static function set(string $value): void
    {
        static::$value .= $value;
    }

    public static function reset(): void
    {
        static::$value = null;
    }
}
