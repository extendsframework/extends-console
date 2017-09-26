<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Color\LightCyan;

use PHPUnit\Framework\TestCase;

class LightCyanTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Formatter\Color\LightCyan\LightCyan::getName()
     */
    public function testCanGetName(): void
    {
        $format = new LightCyan();
        $name = $format->getName();

        static::assertSame('LightCyan', $name);
    }
}
