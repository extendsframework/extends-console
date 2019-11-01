<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Color\LightBlue;

use PHPUnit\Framework\TestCase;

class LightBlueTest extends TestCase
{
    /**
     * Get parameters.
     *
     * Test if all the get parameters return the given construct values.
     *
     * @covers \ExtendsFramework\Console\Formatter\Color\LightBlue\LightBlue::getName()
     */
    public function testGetParameters(): void
    {
        $format = new LightBlue();
        $name = $format->getName();

        $this->assertSame('LightBlue', $name);
    }
}
