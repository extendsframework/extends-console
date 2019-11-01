<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Format\Blink;

use ExtendsFramework\Console\Formatter\Format\FormatInterface;

class Blink implements FormatInterface
{
    /**
     * @const string
     */
    public const NAME = 'Blink';

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return self::NAME;
    }
}
