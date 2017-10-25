<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\ServiceLocator\Loader;

use ExtendsFramework\Console\ServiceLocator\Factory\ShellFactory;
use ExtendsFramework\Console\ServiceLocator\Factory\TerminalFactory;
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
            ShellInterface::class => [
                'name' => 'Extends Framework Console',
                'program' => 'extends',
                'version' => '0.1',
                'commands' => [],
            ],
        ];
    }
}
