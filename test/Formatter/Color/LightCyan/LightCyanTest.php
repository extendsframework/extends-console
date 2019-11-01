<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Color\LightCyan;

use PHPUnit\Framework\TestCase;

class LightCyanTest extends TestCase
{
    /**
     * Get parameters.
     *
     * Test if all the get parameters return the given construct values.
     *
     * @covers \ExtendsFramework\Console\Formatter\Color\LightCyan\LightCyan::getName()
     */
    public function testGetParameters(): void
    {
        $format = new LightCyan();
        $name = $format->getName();

        $this->assertSame('LightCyan', $name);
    }
}
