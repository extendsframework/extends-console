<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Parser;

use ExtendsFramework\ServiceLocator\ServiceLocatorInterface;
use PHPUnit\Framework\TestCase;

class ParserFactoryTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Parser\ParserFactory::create()
     */
    public function testCanCreateParser(): void
    {
        $serviceLocator = $this->createMock(ServiceLocatorInterface::class);

        /**
         * @var ServiceLocatorInterface $serviceLocator
         */
        $factory = new ParserFactory();
        $parser = $factory->create(ParserInterface::class, $serviceLocator);

        $this->assertInstanceOf(ParserInterface::class, $parser);
    }
}
