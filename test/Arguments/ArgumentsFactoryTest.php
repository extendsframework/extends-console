<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Arguments;

use ExtendsFramework\ServiceLocator\ServiceLocatorInterface;
use PHPUnit\Framework\TestCase;

class ArgumentsFactoryTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Arguments\ArgumentsFactory::create()
     */
    public function testCanCreateArgumentsInterface(): void
    {
        $serviceLocator = $this->createMock(ServiceLocatorInterface::class);

        /**
         * @var ServiceLocatorInterface $serviceLocator
         */
        $factory = new ArgumentsFactory();
        $arguments = $factory->create(ArgumentsInterface::class, $serviceLocator);

        $this->assertInstanceOf(ArgumentsInterface::class, $arguments);
    }
}
