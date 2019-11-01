<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Format\Blink;

use PHPUnit\Framework\TestCase;

class BlinkTest extends TestCase
{
    /**
     * Get parameters.
     *
     * Test if all the get parameters return the given construct values.
     *
     * @covers \ExtendsFramework\Console\Formatter\Format\Blink\Blink::getName()
     */
    public function testGetParameters(): void
    {
        $format = new Blink();
        $name = $format->getName();

        $this->assertSame('Blink', $name);
    }
}
