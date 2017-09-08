<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Input\Stream\Exception;

use Exception;
use ExtendsFramework\Console\Input\InputException;

class StreamReadFailed extends Exception implements InputException
{
    /**
     * When failed to read from stream.
     */
    public function __construct()
    {
        parent::__construct('Failed to read from stream.');
    }
}
