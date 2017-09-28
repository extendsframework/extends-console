<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Parser;

use ExtendsFramework\Console\Parser\Posix\PosixParser;
use ExtendsFramework\ServiceLocator\Resolver\Factory\ServiceFactoryInterface;
use ExtendsFramework\ServiceLocator\ServiceLocatorInterface;

class ParserFactory implements ServiceFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function create(string $key, ServiceLocatorInterface $serviceLocator): ParserInterface
    {
        return new PosixParser();
    }
}
