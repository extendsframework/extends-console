<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Output\Adapter\Stream\Exception;

use ExtendsFramework\Console\Output\Adapter\AdapterException;

class InvalidResourceType extends AdapterException
{
    /**
     * When $resource is not a resource.
     *
     * @param mixed $resource
     */
    public function __construct($resource)
    {
        parent::__construct(sprintf(
            'Output stream must be a resource, got "%s".',
            is_resource($resource) ? get_resource_type($resource) : gettype($resource)
        ));
    }
}
