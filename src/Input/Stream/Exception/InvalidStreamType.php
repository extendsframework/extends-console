<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Input\Stream\Exception;

use Exception;
use ExtendsFramework\Console\Input\InputException;

class InvalidStreamType extends Exception implements InputException
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
