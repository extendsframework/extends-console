<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Color\LightRed;

use PHPUnit\Framework\TestCase;

class LightRedTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Formatter\Color\LightRed\LightRed::getName()
     */
    public function testCanGetName(): void
    {
        $format = new LightRed();
        $name = $format->getName();

        static::assertSame('LightRed', $name);
    }
}
