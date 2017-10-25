<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Terminal;

use ExtendsFramework\Console\Shell\ShellInterface;
use ExtendsFramework\Console\Shell\ShellResultInterface;
use ExtendsFramework\Console\Task\TaskException;
use ExtendsFramework\Console\Task\TaskInterface;
use ExtendsFramework\Console\Terminal\Exception\TaskExecuteFailed;
use ExtendsFramework\Console\Terminal\Exception\TaskNotFound;
use ExtendsFramework\Console\Terminal\Exception\TaskParameterMissing;
use ExtendsFramework\Logger\LoggerInterface;
use ExtendsFramework\ServiceLocator\ServiceLocatorException;
use ExtendsFramework\ServiceLocator\ServiceLocatorInterface;

class Terminal implements TerminalInterface
{
    /**
     * Shell.
     *
     * @var ShellInterface
     */
    protected $shell;

    /**
     * Logger.
     *
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Service locator.
     *
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * Terminal constructor.
     *
     * @param ShellInterface          $shell
     * @param LoggerInterface         $logger
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function __construct(ShellInterface $shell, LoggerInterface $logger, ServiceLocatorInterface $serviceLocator)
    {
        $this->shell = $shell;
        $this->logger = $logger;
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * @inheritDoc
     */
    public function run(): void
    {
        try {
            $this->process(array_slice($GLOBALS['argv'], 1));
        } catch (TerminalException $exception) {
            $this->logger->log($exception->getMessage());
        }
    }

    /**
     * Process $arguments and return task result.
     *
     * @param array $arguments
     * @return void
     * @throws TaskExecuteFailed
     * @throws TaskNotFound
     * @throws TaskParameterMissing
     */
    protected function process(array $arguments): void
    {
        $result = $this->shell->process($arguments);
        if ($result instanceof ShellResultInterface) {
            $command = $result->getCommand();

            $parameters = $command->getParameters();
            if (array_key_exists('task', $parameters) === false) {
                throw new TaskParameterMissing($command);
            }

            try {
                $task = $this->getTask($parameters['task']);
            } catch (ServiceLocatorException $exception) {
                throw new TaskNotFound($command, $exception);
            }

            try {
                $task->execute(
                    $result->getData()
                );
            } catch (TaskException $exception) {
                throw new TaskExecuteFailed($command, $exception);
            }
        }
    }

    /**
     * Get task for $key from service locator.
     *
     * @param string $key
     * @return TaskInterface
     * @throws ServiceLocatorException
     */
    protected function getTask(string $key): TaskInterface
    {
        return $this->serviceLocator->getService($key);
    }
}
