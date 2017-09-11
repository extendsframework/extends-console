<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Output\Stream\Exception;

use Exception;
use ExtendsFramework\Console\Output\OutputException;

class StreamWriteFailed extends Exception implements OutputException
{
    /**
     * When failed to write to stream.
     */
    public function __construct()
    {
        parent::__construct('Failed to write to stream.');
    }
}
