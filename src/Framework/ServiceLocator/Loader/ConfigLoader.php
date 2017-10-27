<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Framework\ServiceLocator\Loader;

use ExtendsFramework\Console\Framework\ServiceLocator\Factory\ShellFactory;
use ExtendsFramework\Console\Framework\ServiceLocator\Factory\TerminalFactory;
use ExtendsFramework\Console\Shell\ShellInterface;
use ExtendsFramework\Console\Terminal\TerminalInterface;
use ExtendsFramework\ServiceLocator\Config\Loader\LoaderInterface;
use ExtendsFramework\ServiceLocator\Resolver\Factory\FactoryResolver;
use ExtendsFramework\ServiceLocator\ServiceLocatorInterface;

class ConfigLoader implements LoaderInterface
{
    /**
     * @inheritDoc
     */
    public function load(): array
    {
        return [
            ServiceLocatorInterface::class => [
                FactoryResolver::class => [
                    ShellInterface::class => ShellFactory::class,
                    TerminalInterface::class => TerminalFactory::class,
                ],
            ],
        ];
    }
}
