<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Color\DarkGray;

use ExtendsFramework\Console\Formatter\Color\ColorInterface;

class DarkGray implements ColorInterface
{
    /**
     * @const string
     */
    public const NAME = 'DarkGray';

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return self::NAME;
    }
}
