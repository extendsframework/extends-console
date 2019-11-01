<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Color\LightGreen;

use ExtendsFramework\Console\Formatter\Color\ColorInterface;

class LightGreen implements ColorInterface
{
    /**
     * @const string
     */
    public const NAME = 'LightGreen';

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return self::NAME;
    }
}
