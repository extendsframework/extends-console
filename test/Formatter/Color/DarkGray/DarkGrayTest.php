<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Color\DarkGray;

use PHPUnit\Framework\TestCase;

class DarkGrayTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Formatter\Color\DarkGray\DarkGray::getName()
     */
    public function testCanGetName(): void
    {
        $format = new DarkGray();
        $name = $format->getName();

        static::assertSame('DarkGray', $name);
    }
}
