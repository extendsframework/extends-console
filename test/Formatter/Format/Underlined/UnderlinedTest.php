<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Format\Underlined;

use PHPUnit\Framework\TestCase;

class UnderlinedTest extends TestCase
{
    /**
     * Get parameters.
     *
     * Test if all the get parameters return the given construct values.
     *
     * @covers \ExtendsFramework\Console\Formatter\Format\Underlined\Underlined::getName()
     */
    public function testGetParameters(): void
    {
        $format = new Underlined();
        $name = $format->getName();

        $this->assertSame('Underlined', $name);
    }
}
