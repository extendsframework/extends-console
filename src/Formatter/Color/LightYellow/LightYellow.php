<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Color\LightYellow;

use ExtendsFramework\Console\Formatter\Color\ColorInterface;

class LightYellow implements ColorInterface
{
    /**
     * @const string
     */
    public const NAME = 'LightYellow';

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return self::NAME;
    }
}
