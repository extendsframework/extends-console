<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Format\Dim;

use ExtendsFramework\Console\Formatter\Format\FormatInterface;

class Dim implements FormatInterface
{
    /**
     * @const string
     */
    public const NAME = 'Dim';

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return self::NAME;
    }
}
