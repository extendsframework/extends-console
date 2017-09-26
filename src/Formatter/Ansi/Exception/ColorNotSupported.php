<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Ansi\Exception;

use ExtendsFramework\Console\Formatter\Color\ColorInterface;
use RuntimeException;

class ColorNotSupported extends RuntimeException
{
    /**
     * @param ColorInterface $color
     */
    public function __construct(ColorInterface $color)
    {
        parent::__construct(sprintf(
            'Color "%s" is not supported.',
            $color->getName()
        ));
    }
}
