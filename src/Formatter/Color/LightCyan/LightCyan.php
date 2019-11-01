<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Color\LightCyan;

use ExtendsFramework\Console\Formatter\Color\ColorInterface;

class LightCyan implements ColorInterface
{
    /**
     * @const string
     */
    public const NAME = 'LightCyan';

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return self::NAME;
    }
}
