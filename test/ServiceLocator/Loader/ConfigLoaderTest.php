<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\ServiceLocator\Loader;

use ExtendsFramework\Console\ServiceLocator\Factory\ShellFactory;
use ExtendsFramework\Console\Shell\ShellInterface;
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
            'service_locator' => [
                'factories' => [
                    ShellInterface::class => ShellFactory::class,
                ],
            ],
        ], $loader->load());
    }
}
