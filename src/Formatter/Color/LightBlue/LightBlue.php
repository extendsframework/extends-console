<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Color\LightBlue;

use ExtendsFramework\Console\Formatter\Color\ColorInterface;

class LightBlue implements ColorInterface
{
    /**
     * @const string
     */
    public const NAME = 'LightBlue';

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return self::NAME;
    }
}
