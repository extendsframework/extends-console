<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Framework\ServiceLocator\Loader;

use ExtendsFramework\Console\Input\InputInterface;
use ExtendsFramework\Console\Input\Posix\PosixInput;
use ExtendsFramework\Console\Output\OutputInterface;
use ExtendsFramework\Console\Output\Posix\PosixOutput;
use ExtendsFramework\ServiceLocator\Resolver\Invokable\InvokableResolver;
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
                InvokableResolver::class => [
                    InputInterface::class => PosixInput::class,
                    OutputInterface::class => PosixOutput::class,
                ],
            ],
        ], $loader->load());
    }
}
