<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Color\LightGray;

use PHPUnit\Framework\TestCase;

class LightGrayTest extends TestCase
{
    /**
     * Get parameters.
     *
     * Test if all the get parameters return the given construct values.
     *
     * @covers \ExtendsFramework\Console\Formatter\Color\LightGray\LightGray::getName()
     */
    public function testGetParameters(): void
    {
        $format = new LightGray();
        $name = $format->getName();

        $this->assertSame('LightGray', $name);
    }
}
