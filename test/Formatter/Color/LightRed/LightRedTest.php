<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Color\LightRed;

use PHPUnit\Framework\TestCase;

class LightRedTest extends TestCase
{
    /**
     * Get parameters.
     *
     * Test if all the get parameters return the given construct values.
     *
     * @covers \ExtendsFramework\Console\Formatter\Color\LightRed\LightRed::getName()
     */
    public function testGetParameters(): void
    {
        $format = new LightRed();
        $name = $format->getName();

        $this->assertSame('LightRed', $name);
    }
}
