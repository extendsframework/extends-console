<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Terminal\Exception;

use ExtendsFramework\Shell\Command\CommandInterface;
use ExtendsFramework\Console\Terminal\TerminalException;
use InvalidArgumentException;

class TaskParameterMissing extends InvalidArgumentException implements TerminalException
{
    /**
     * TaskParameterMissing constructor.
     *
     * @param CommandInterface $command
     */
    public function __construct(CommandInterface $command)
    {
        parent::__construct(sprintf(
            'Task parameter not defined for command "%s".',
            $command->getName()
        ));
    }
}
