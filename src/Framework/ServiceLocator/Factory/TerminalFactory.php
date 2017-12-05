<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Framework\ServiceLocator\Factory;

use ExtendsFramework\Shell\ShellInterface;
use ExtendsFramework\Terminal\Terminal;
use ExtendsFramework\Terminal\TerminalInterface;
use ExtendsFramework\Logger\LoggerInterface;
use ExtendsFramework\ServiceLocator\Resolver\Factory\ServiceFactoryInterface;
use ExtendsFramework\ServiceLocator\ServiceLocatorInterface;

class TerminalFactory implements ServiceFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function createService(string $key, ServiceLocatorInterface $serviceLocator, array $extra = null): TerminalInterface
    {
        return new Terminal(
            $serviceLocator->getService(ShellInterface::class),
            $serviceLocator->getService(LoggerInterface::class),
            $serviceLocator
        );
    }
}
