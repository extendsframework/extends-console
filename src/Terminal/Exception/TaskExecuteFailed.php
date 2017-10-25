<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Terminal\Exception;

use ExtendsFramework\Console\Shell\Command\CommandInterface;
use ExtendsFramework\Console\Task\TaskException;
use ExtendsFramework\Console\Terminal\TerminalException;
use InvalidArgumentException;

class TaskExecuteFailed extends InvalidArgumentException implements TerminalException
{
    /**
     * TaskExecuteFailed constructor.
     *
     * @param CommandInterface $command
     * @param TaskException    $exception
     */
    public function __construct(CommandInterface $command, TaskException $exception)
    {
        parent::__construct(sprintf(
            'Failed to execute task for command "%s", see previous exception for more details.',
            $command->getName()
        ), 0, $exception);
    }
}
