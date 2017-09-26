<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Format\Blink;

use PHPUnit\Framework\TestCase;

class BlinkTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Formatter\Format\Blink\Blink::getName()
     */
    public function testCanGetName(): void
    {
        $format = new Blink();
        $name = $format->getName();

        static::assertSame('Blink', $name);
    }
}
