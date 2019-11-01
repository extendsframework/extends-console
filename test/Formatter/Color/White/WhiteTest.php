<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Color\White;

use PHPUnit\Framework\TestCase;

class WhiteTest extends TestCase
{
    /**
     * Get parameters.
     *
     * Test if all the get parameters return the given construct values.
     *
     * @covers \ExtendsFramework\Console\Formatter\Color\White\White::getName()
     */
    public function testGetParameters(): void
    {
        $format = new White();
        $name = $format->getName();

        $this->assertSame('White', $name);
    }
}
