<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Color\Black;

use ExtendsFramework\Console\Formatter\Color\ColorInterface;

class Black implements ColorInterface
{
    /**
     * @const string
     */
    public const NAME = 'Black';

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return self::NAME;
    }
}
