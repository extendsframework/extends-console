<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Ansi\Exception;

use RuntimeException;

class InvalidColorName extends RuntimeException
{
    /**
     * When no color is found for $name.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        parent::__construct(sprintf(
            'No color found for name "%s".',
            $name
        ));
    }
}
