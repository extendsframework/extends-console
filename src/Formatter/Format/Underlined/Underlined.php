<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Format\Underlined;

use ExtendsFramework\Console\Formatter\Format\FormatInterface;

class Underlined implements FormatInterface
{
    /**
     * @const string
     */
    const NAME = 'Underlined';

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return self::NAME;
    }
}
