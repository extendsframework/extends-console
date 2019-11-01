<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Color\Blue;

use ExtendsFramework\Console\Formatter\Color\ColorInterface;

class Blue implements ColorInterface
{
    /**
     * @const string
     */
    public const NAME = 'Blue';

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return self::NAME;
    }
}
