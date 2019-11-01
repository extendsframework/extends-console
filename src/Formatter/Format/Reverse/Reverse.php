<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Format\Reverse;

use ExtendsFramework\Console\Formatter\Format\FormatInterface;

class Reverse implements FormatInterface
{
    /**
     * @const string
     */
    public const NAME = 'Reverse';

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return self::NAME;
    }
}
