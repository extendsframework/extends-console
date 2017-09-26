<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Color\LightYellow;

use PHPUnit\Framework\TestCase;

class LightYellowTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Formatter\Color\LightYellow\LightYellow::getName()
     */
    public function testCanGetName(): void
    {
        $format = new LightYellow();
        $name = $format->getName();

        static::assertSame('LightYellow', $name);
    }
}
