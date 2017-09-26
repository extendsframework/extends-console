<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Color\Blue;

use PHPUnit\Framework\TestCase;

class BlueTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Formatter\Color\Blue\Blue::getName()
     */
    public function testCanGetName(): void
    {
        $format = new Blue();
        $name = $format->getName();

        static::assertSame('Blue', $name);
    }
}
