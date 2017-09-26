<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Color\Red;

use PHPUnit\Framework\TestCase;

class RedTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Formatter\Color\Red\Red::getName()
     */
    public function testCanGetName(): void
    {
        $format = new Red();
        $name = $format->getName();

        static::assertSame('Red', $name);
    }
}
