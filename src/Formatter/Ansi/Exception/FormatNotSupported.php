<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Ansi\Exception;

use ExtendsFramework\Console\Formatter\Format\FormatInterface;
use RuntimeException;

class FormatNotSupported extends RuntimeException
{
    /**
     * @param FormatInterface $format
     */
    public function __construct(FormatInterface $format)
    {
        parent::__construct(sprintf(
            'Format "%s" is not supported.',
            $format->getName()
        ));
    }
}
