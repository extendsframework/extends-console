<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Output;

use ExtendsFramework\ServiceLocator\ServiceLocatorInterface;
use PHPUnit\Framework\TestCase;

class OutputFactoryTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Output\OutputFactory::create()
     */
    public function testCanCreateOutputService(): void
    {
        $serviceLocator = $this->createMock(ServiceLocatorInterface::class);

        /**
         * @var ServiceLocatorInterface $serviceLocator
         */
        $factory = new OutputFactory();
        $output = $factory->create(OutputInterface::class, $serviceLocator);

        $this->assertInstanceOf(OutputInterface::class, $output);
    }
}
