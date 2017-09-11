<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Output\Stream\Exception;

use Exception;
use ExtendsFramework\Console\Output\OutputException;

class InvalidStreamType extends Exception implements OutputException
{
    /**
     * When $resource is not a resource of type stream.
     *
     * @param mixed $resource
     */
    public function __construct($resource)
    {
        parent::__construct(sprintf(
            'Resource must be of type stream, got "%s".',
            is_resource($resource) ? get_resource_type($resource) : gettype($resource)
        ));
    }
}
