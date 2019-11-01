<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Color\Blue;

use PHPUnit\Framework\TestCase;

class BlueTest extends TestCase
{
    /**
     * Get parameters.
     *
     * Test if all the get parameters return the given construct values.
     *
     * @covers \ExtendsFramework\Console\Formatter\Color\Blue\Blue::getName()
     */
    public function testGetParameters(): void
    {
        $format = new Blue();
        $name = $format->getName();

        $this->assertSame('Blue', $name);
    }
}
