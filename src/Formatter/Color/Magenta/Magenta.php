<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Color\Magenta;

use ExtendsFramework\Console\Formatter\Color\ColorInterface;

class Magenta implements ColorInterface
{
    /**
     * @const string
     */
    public const NAME = 'Magenta';

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return self::NAME;
    }
}
