<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Color\Red;

use ExtendsFramework\Console\Formatter\Color\ColorInterface;

class Red implements ColorInterface
{
    /**
     * @const string
     */
    public const NAME = 'Red';

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return self::NAME;
    }
}
