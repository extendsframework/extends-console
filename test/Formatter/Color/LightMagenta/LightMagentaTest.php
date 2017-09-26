<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Color\LightMagenta;

use PHPUnit\Framework\TestCase;

class LightMagentaTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Formatter\Color\LightMagenta\LightMagenta::getName()
     */
    public function testCanGetName(): void
    {
        $format = new LightMagenta();
        $name = $format->getName();

        static::assertSame('LightMagenta', $name);
    }
}
