<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Definition\Exception;

use Exception;
use ExtendsFramework\Console\Definition\DefinitionException;

class OptionNotFound extends Exception implements DefinitionException
{
    /**
     * No option with $name.
     *
     * @param string    $name
     * @param bool|null $long
     */
    public function __construct(string $name, bool $long = null)
    {
        parent::__construct(sprintf(
            'No %s option found for name "%s".',
            $long ? 'long' : 'short',
            ($long ? '--' : '-') . $name
        ));
    }
}