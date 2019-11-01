<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Color\Red;

use PHPUnit\Framework\TestCase;

class RedTest extends TestCase
{
    /**
     * Get parameters.
     *
     * Test if all the get parameters return the given construct values.
     *
     * @covers \ExtendsFramework\Console\Formatter\Color\Red\Red::getName()
     */
    public function testGetParameters(): void
    {
        $format = new Red();
        $name = $format->getName();

        $this->assertSame('Red', $name);
    }
}
