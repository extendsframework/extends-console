<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Framework\ServiceLocator\Factory;

use ExtendsFramework\Shell\ShellInterface;
use ExtendsFramework\Console\Terminal\TerminalInterface;
use ExtendsFramework\Logger\LoggerInterface;
use ExtendsFramework\ServiceLocator\ServiceLocatorInterface;
use PHPUnit\Framework\TestCase;

class TerminalFactoryTest extends TestCase
{
    /**
     * Create service.
     *
     * Test that factory will return an TerminalInterface instance.
     *
     * @covers \ExtendsFramework\Console\Framework\ServiceLocator\Factory\TerminalFactory::createService()
     */
    public function testCreateService(): void
    {
        $serviceLocator = $this->createMock(ServiceLocatorInterface::class);
        $serviceLocator
            ->expects($this->exactly(2))
            ->method('getService')
            ->withConsecutive(
                [ShellInterface::class],
                [LoggerInterface::class]
            )
            ->willReturnOnConsecutiveCalls(
                $this->createMock(ShellInterface::class),
                $this->createMock(LoggerInterface::class)
            );

        /**
         * @var ServiceLocatorInterface $serviceLocator
         */
        $factory = new TerminalFactory();
        $terminal = $factory->createService(TerminalInterface::class, $serviceLocator, []);

        $this->assertInstanceOf(TerminalInterface::class, $terminal);
    }
}
