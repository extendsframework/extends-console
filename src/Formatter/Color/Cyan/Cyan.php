<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Color\Cyan;

use ExtendsFramework\Console\Formatter\Color\ColorInterface;

class Cyan implements ColorInterface
{
    /**
     * @const string
     */
    public const NAME = 'Cyan';

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return self::NAME;
    }
}
