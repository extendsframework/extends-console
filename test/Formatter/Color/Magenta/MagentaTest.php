<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Color\Magenta;

use PHPUnit\Framework\TestCase;

class MagentaTest extends TestCase
{
    /**
     * Get parameters.
     *
     * Test if all the get parameters return the given construct values.
     *
     * @covers \ExtendsFramework\Console\Formatter\Color\Magenta\Magenta::getName()
     */
    public function testGetParameters(): void
    {
        $format = new Magenta();
        $name = $format->getName();

        $this->assertSame('Magenta', $name);
    }
}
