<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Terminal;

use Exception;
use ExtendsFramework\Console\Shell\Command\CommandInterface;
use ExtendsFramework\Console\Shell\ShellInterface;
use ExtendsFramework\Console\Shell\ShellResultInterface;
use ExtendsFramework\Console\Task\TaskException;
use ExtendsFramework\Console\Task\TaskInterface;
use ExtendsFramework\Logger\LoggerInterface;
use ExtendsFramework\ServiceLocator\ServiceLocatorException;
use ExtendsFramework\ServiceLocator\ServiceLocatorInterface;
use PHPUnit\Framework\TestCase;
use stdClass;

class TerminalTest extends TestCase
{
    /**
     * Run.
     *
     * Test that task will be executed for given command.
     *
     * @covers \ExtendsFramework\Console\Terminal\Terminal::__construct()
     * @covers \ExtendsFramework\Console\Terminal\Terminal::run()
     * @covers \ExtendsFramework\Console\Terminal\Terminal::process()
     * @covers \ExtendsFramework\Console\Terminal\Terminal::getTask()
     */
    public function testRun(): void
    {
        $GLOBALS['argv'] = [
            'test.php',
            'do.task',
        ];

        $command = $this->createMock(CommandInterface::class);
        $command
            ->expects($this->once())
            ->method('getParameters')
            ->willReturn([
                'task' => stdClass::class,
            ]);

        $result = $this->createMock(ShellResultInterface::class);
        $result
            ->expects($this->once())
            ->method('getCommand')
            ->willReturn($command);

        $result
            ->expects($this->once())
            ->method('getData')
            ->willReturn([
                'foo' => 'bar',
            ]);

        $shell = $this->createMock(ShellInterface::class);
        $shell
            ->expects($this->once())
            ->method('process')
            ->with([
                'do.task',
            ])
            ->willReturn($result);

        $task = $this->createMock(TaskInterface::class);
        $task
            ->expects($this->once())
            ->method('execute')
            ->with([
                'foo' => 'bar',
            ]);

        $serviceLocator = $this->createMock(ServiceLocatorInterface::class);
        $serviceLocator
            ->expects($this->once())
            ->method('getService')
            ->with(stdClass::class)
            ->willReturn($task);

        $logger = $this->createMock(LoggerInterface::class);

        /**
         * @var ShellInterface          $shell
         * @var LoggerInterface         $logger
         * @var ServiceLocatorInterface $serviceLocator
         */
        $terminal = new Terminal($shell, $logger, $serviceLocator);
        $terminal->run();
    }

    /**
     * Task parameter missing.
     *
     * Test that a log will be written when task parameter is missing in command.
     *
     * @covers \ExtendsFramework\Console\Terminal\Terminal::__construct()
     * @covers \ExtendsFramework\Console\Terminal\Terminal::run()
     * @covers \ExtendsFramework\Console\Terminal\Terminal::process()
     * @covers \ExtendsFramework\Console\Terminal\Exception\TaskParameterMissing::__construct()
     */
    public function testTaskParameterMissing(): void
    {
        $GLOBALS['argv'] = [
            'test.php',
            'do.task',
        ];

        $command = $this->createMock(CommandInterface::class);
        $command
            ->expects($this->once())
            ->method('getParameters')
            ->willReturn([]);

        $command
            ->expects($this->once())
            ->method('getName')
            ->willReturn('do.task');

        $result = $this->createMock(ShellResultInterface::class);
        $result
            ->expects($this->once())
            ->method('getCommand')
            ->willReturn($command);

        $shell = $this->createMock(ShellInterface::class);
        $shell
            ->expects($this->once())
            ->method('process')
            ->with([
                'do.task',
            ])
            ->willReturn($result);

        $logger = $this->createMock(LoggerInterface::class);
        $logger
            ->expects($this->once())
            ->method('log')
            ->with('Task parameter not defined for command "do.task".');

        $serviceLocator = $this->createMock(ServiceLocatorInterface::class);

        /**
         * @var ShellInterface          $shell
         * @var LoggerInterface         $logger
         * @var ServiceLocatorInterface $serviceLocator
         */
        $terminal = new Terminal($shell, $logger, $serviceLocator);
        $terminal->run();
    }

    /**
     * Task task not found.
     *
     * Test that a log will be written when task can not be found by service locator.
     *
     * @covers \ExtendsFramework\Console\Terminal\Terminal::__construct()
     * @covers \ExtendsFramework\Console\Terminal\Terminal::run()
     * @covers \ExtendsFramework\Console\Terminal\Terminal::process()
     * @covers \ExtendsFramework\Console\Terminal\Terminal::getTask()
     * @covers \ExtendsFramework\Console\Terminal\Exception\TaskNotFound::__construct()
     */
    public function testTaskNotFound(): void
    {
        $GLOBALS['argv'] = [
            'test.php',
            'do.task',
        ];

        $command = $this->createMock(CommandInterface::class);
        $command
            ->expects($this->once())
            ->method('getParameters')
            ->willReturn([
                'task' => stdClass::class,
            ]);

        $result = $this->createMock(ShellResultInterface::class);
        $result
            ->expects($this->once())
            ->method('getCommand')
            ->willReturn($command);

        $shell = $this->createMock(ShellInterface::class);
        $shell
            ->expects($this->once())
            ->method('process')
            ->with([
                'do.task',
            ])
            ->willReturn($result);

        $serviceLocator = $this->createMock(ServiceLocatorInterface::class);
        $serviceLocator
            ->expects($this->once())
            ->method('getService')
            ->with(stdClass::class)
            ->willThrowException(new ServiceLocatorExceptionStub());

        $logger = $this->createMock(LoggerInterface::class);

        /**
         * @var ShellInterface          $shell
         * @var LoggerInterface         $logger
         * @var ServiceLocatorInterface $serviceLocator
         */
        $terminal = new Terminal($shell, $logger, $serviceLocator);
        $terminal->run();
    }

    /**
     * Task parameter missing.
     *
     * Test that a log will be written when task execution fails.
     *
     * @covers \ExtendsFramework\Console\Terminal\Terminal::__construct()
     * @covers \ExtendsFramework\Console\Terminal\Terminal::run()
     * @covers \ExtendsFramework\Console\Terminal\Terminal::process()
     * @covers \ExtendsFramework\Console\Terminal\Terminal::getTask()
     * @covers \ExtendsFramework\Console\Terminal\Exception\TaskExecuteFailed::__construct()
     */
    public function testTaskExecuteFailed(): void
    {
        $GLOBALS['argv'] = [
            'test.php',
            'do.task',
        ];

        $command = $this->createMock(CommandInterface::class);
        $command
            ->expects($this->once())
            ->method('getParameters')
            ->willReturn([
                'task' => stdClass::class,
            ]);

        $result = $this->createMock(ShellResultInterface::class);
        $result
            ->expects($this->once())
            ->method('getCommand')
            ->willReturn($command);

        $result
            ->expects($this->once())
            ->method('getData')
            ->willReturn([
                'foo' => 'bar',
            ]);

        $shell = $this->createMock(ShellInterface::class);
        $shell
            ->expects($this->once())
            ->method('process')
            ->with([
                'do.task',
            ])
            ->willReturn($result);

        $task = $this->createMock(TaskInterface::class);
        $task
            ->expects($this->once())
            ->method('execute')
            ->with([
                'foo' => 'bar',
            ])
            ->willThrowException(new TaskExceptionStub());

        $serviceLocator = $this->createMock(ServiceLocatorInterface::class);
        $serviceLocator
            ->expects($this->once())
            ->method('getService')
            ->with(stdClass::class)
            ->willReturn($task);

        $logger = $this->createMock(LoggerInterface::class);

        /**
         * @var ShellInterface          $shell
         * @var LoggerInterface         $logger
         * @var ServiceLocatorInterface $serviceLocator
         */
        $terminal = new Terminal($shell, $logger, $serviceLocator);
        $terminal->run();
    }
}

class TaskExceptionStub extends Exception implements TaskException
{
}

class ServiceLocatorExceptionStub extends Exception implements ServiceLocatorException
{
}
