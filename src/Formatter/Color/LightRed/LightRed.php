<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Color\LightRed;

use ExtendsFramework\Console\Formatter\Color\ColorInterface;

class LightRed implements ColorInterface
{
    /**
     * @const string
     */
    public const NAME = 'LightRed';

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return self::NAME;
    }
}
