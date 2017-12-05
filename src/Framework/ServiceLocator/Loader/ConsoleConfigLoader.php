<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Framework\ServiceLocator\Loader;

use ExtendsFramework\Console\Input\InputInterface;
use ExtendsFramework\Console\Input\Posix\PosixInput;
use ExtendsFramework\Console\Output\OutputInterface;
use ExtendsFramework\Console\Output\Posix\PosixOutput;
use ExtendsFramework\ServiceLocator\Config\Loader\LoaderInterface;
use ExtendsFramework\ServiceLocator\Resolver\Invokable\InvokableResolver;
use ExtendsFramework\ServiceLocator\ServiceLocatorInterface;

class ConsoleConfigLoader implements LoaderInterface
{
    /**
     * @inheritDoc
     */
    public function load(): array
    {
        return [
            ServiceLocatorInterface::class => [
                InvokableResolver::class => [
                    InputInterface::class => PosixInput::class,
                    OutputInterface::class => PosixOutput::class,
                ],
            ],
        ];
    }
}
