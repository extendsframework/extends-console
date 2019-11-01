<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Format\Reverse;

use PHPUnit\Framework\TestCase;

class ReverseTest extends TestCase
{
    /**
     * Get parameters.
     *
     * Test if all the get parameters return the given construct values.
     *
     * @covers \ExtendsFramework\Console\Formatter\Format\Reverse\Reverse::getName()
     */
    public function testGetParameters(): void
    {
        $format = new Reverse();
        $name = $format->getName();

        $this->assertSame('Reverse', $name);
    }
}
