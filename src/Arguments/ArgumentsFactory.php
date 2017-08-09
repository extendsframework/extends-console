<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Arguments;

use ExtendsFramework\ServiceLocator\Resolver\Factory\ServiceFactoryInterface;
use ExtendsFramework\ServiceLocator\ServiceLocatorInterface;

class ArgumentsFactory implements ServiceFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function create(string $key, ServiceLocatorInterface $serviceLocator): ArgumentsInterface
    {
        global $argv;

        return new Arguments(
            ...array_slice($argv, 1)
        );
    }
}
