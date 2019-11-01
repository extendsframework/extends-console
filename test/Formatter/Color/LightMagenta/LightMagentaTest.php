<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Color\LightMagenta;

use PHPUnit\Framework\TestCase;

class LightMagentaTest extends TestCase
{
    /**
     * Get parameters.
     *
     * Test if all the get parameters return the given construct values.
     *
     * @covers \ExtendsFramework\Console\Formatter\Color\LightMagenta\LightMagenta::getName()
     */
    public function testGetParameters(): void
    {
        $format = new LightMagenta();
        $name = $format->getName();

        $this->assertSame('LightMagenta', $name);
    }
}
