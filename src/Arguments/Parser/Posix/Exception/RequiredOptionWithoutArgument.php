<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Arguments\Parser\Posix\Exception;

use Exception;
use ExtendsFramework\Console\Arguments\Definition\Option\OptionInterface;
use ExtendsFramework\Console\Arguments\Parser\ParserException;

class RequiredOptionWithoutArgument extends Exception implements ParserException
{
    /**
     * Required option has no argument.
     *
     * @param OptionInterface $option
     * @param bool|null       $long
     */
    public function __construct(OptionInterface $option, bool $long = null)
    {
        parent::__construct(sprintf(
            '%s option "%s" requires an argument, non given.',
            $long ? 'Long' : 'Short',
            $long ? '--' . $option->getLong() : '-' . $option->getShort()
        ));
    }
}
