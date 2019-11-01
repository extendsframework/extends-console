<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Color\Yellow;

use PHPUnit\Framework\TestCase;

class YellowTest extends TestCase
{
    /**
     * Get parameters.
     *
     * Test if all the get parameters return the given construct values.
     *
     * @covers \ExtendsFramework\Console\Formatter\Color\Yellow\Yellow::getName()
     */
    public function testGetParameters(): void
    {
        $format = new Yellow();
        $name = $format->getName();

        $this->assertSame('Yellow', $name);
    }
}
