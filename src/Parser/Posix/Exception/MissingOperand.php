<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Parser\Posix\Exception;

use Exception;
use ExtendsFramework\Console\Parser\ParserException;

class MissingOperand extends Exception implements ParserException
{
    /**
     * Required operand ...
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        parent::__construct(sprintf(
            'Operand "%s" is required.',
            $name
        ));
    }
}
