<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Color\Yellow;

use ExtendsFramework\Console\Formatter\Color\ColorInterface;

class Yellow implements ColorInterface
{
    /**
     * @const string
     */
    public const NAME = 'Yellow';

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return self::NAME;
    }
}
