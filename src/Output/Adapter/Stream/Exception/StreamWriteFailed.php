<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Output\Adapter\Stream\Exception;

use ExtendsFramework\Console\Output\Adapter\AdapterException;

class StreamWriteFailed extends AdapterException
{
    /**
     * When writing $text to stream failed with $error.
     *
     * @param string $text
     * @param string $error
     */
    public function __construct(string $text, string $error)
    {
        parent::__construct(sprintf(
            'Failed to write "%s" to stream, got "%s".',
            $text,
            $error
        ));
    }
}
