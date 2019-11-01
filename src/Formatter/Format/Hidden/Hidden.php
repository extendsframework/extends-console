<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Format\Hidden;

use ExtendsFramework\Console\Formatter\Format\FormatInterface;

class Hidden implements FormatInterface
{
    /**
     * @const string
     */
    public const NAME = 'Hidden';

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return self::NAME;
    }
}
