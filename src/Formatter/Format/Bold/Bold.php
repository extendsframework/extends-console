<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Format\Bold;

use ExtendsFramework\Console\Formatter\Format\FormatInterface;

class Bold implements FormatInterface
{
    /**
     * @const string
     */
    public const NAME = 'Bold';

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return self::NAME;
    }
}
