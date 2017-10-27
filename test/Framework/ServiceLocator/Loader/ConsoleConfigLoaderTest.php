<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Framework\ServiceLocator\Loader;

use ExtendsFramework\Console\Framework\ServiceLocator\Factory\ShellFactory;
use ExtendsFramework\Console\Framework\ServiceLocator\Factory\TerminalFactory;
use ExtendsFramework\Console\Shell\ShellInterface;
use ExtendsFramework\Console\Terminal\TerminalInterface;
use ExtendsFramework\ServiceLocator\Resolver\Factory\FactoryResolver;
use ExtendsFramework\ServiceLocator\ServiceLocatorInterface;
use PHPUnit\Framework\TestCase;

class ConsoleConfigLoaderTest extends TestCase
{
    /**
     * Load.
     *
     * Test that loader returns correct array.
     *
     * @covers \ExtendsFramework\Console\Framework\ServiceLocator\Loader\ConsoleConfigLoader::load()
     */
    public function testLoad(): void
    {
        $loader = new ConsoleConfigLoader();

        $this->assertSame([
            ServiceLocatorInterface::class => [
                FactoryResolver::class => [
                    ShellInterface::class => ShellFactory::class,
                    TerminalInterface::class => TerminalFactory::class,
                ],
            ],
        ], $loader->load());
    }
}
