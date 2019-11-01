<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Color\White;

use ExtendsFramework\Console\Formatter\Color\ColorInterface;

class White implements ColorInterface
{
    /**
     * @const string
     */
    public const NAME = 'White';

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return self::NAME;
    }
}
