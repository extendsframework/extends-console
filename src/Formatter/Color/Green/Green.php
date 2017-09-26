<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Color\Green;

use ExtendsFramework\Console\Formatter\Color\ColorInterface;

class Green implements ColorInterface
{
    /**
     * @const string
     */
    const NAME = 'Green';

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return self::NAME;
    }
}
