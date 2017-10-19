<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\ServiceLocator\Loader;

use ExtendsFramework\Console\ServiceLocator\Factory\ShellFactory;
use ExtendsFramework\Console\Shell\ShellInterface;
use ExtendsFramework\ServiceLocator\Config\Loader\LoaderInterface;

class ConfigLoader implements LoaderInterface
{
    /**
     * @inheritDoc
     */
    public function load(): array
    {
        return [
            'service_locator' => [
                'factories' => [
                    ShellInterface::class => ShellFactory::class,
                ],
            ],
        ];
    }
}
