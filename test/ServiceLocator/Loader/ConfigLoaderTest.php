<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\ServiceLocator\Loader;

use ExtendsFramework\Console\ServiceLocator\Factory\ShellFactory;
use ExtendsFramework\Console\Shell\ShellInterface;
use ExtendsFramework\ServiceLocator\Resolver\Factory\FactoryResolver;
use ExtendsFramework\ServiceLocator\ServiceLocatorInterface;
use PHPUnit\Framework\TestCase;

class ConfigLoaderTest extends TestCase
{
    /**
     * Load.
     *
     * Test that loader returns correct array.
     *
     * @covers \ExtendsFramework\Console\ServiceLocator\Loader\ConfigLoader::load()
     */
    public function testLoad(): void
    {
        $loader = new ConfigLoader();

        $this->assertSame([
            ServiceLocatorInterface::class => [
                FactoryResolver::class => [
                    ShellInterface::class => ShellFactory::class,
                ],
            ],
            ShellInterface::class => [
                'name' => 'Extends Framework Console',
                'program' => 'extends',
                'version' => '0.1',
                'commands' => [],
            ],
        ], $loader->load());
    }
}
