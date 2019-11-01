<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Color\Green;

use PHPUnit\Framework\TestCase;

class GreenTest extends TestCase
{
    /**
     * Get parameters.
     *
     * Test if all the get parameters return the given construct values.
     *
     * @covers \ExtendsFramework\Console\Formatter\Color\Green\Green::getName()
     */
    public function testGetParameters(): void
    {
        $format = new Green();
        $name = $format->getName();

        $this->assertSame('Green', $name);
    }
}
