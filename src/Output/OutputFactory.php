<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Output;

use ExtendsFramework\Console\Output\Adapter\Stream\StreamAdapter;
use ExtendsFramework\ServiceLocator\Resolver\Factory\ServiceFactoryInterface;
use ExtendsFramework\ServiceLocator\ServiceLocatorInterface;

class OutputFactory implements ServiceFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function create(string $key, ServiceLocatorInterface $serviceLocator): OutputInterface
    {
        return new Output(
            new StreamAdapter(
                fopen('php://stdout', 'wb')
            )
        );
    }
}
