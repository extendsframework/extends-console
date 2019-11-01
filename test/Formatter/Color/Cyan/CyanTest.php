<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Color\Cyan;

use PHPUnit\Framework\TestCase;

class CyanTest extends TestCase
{
    /**
     * Get parameters.
     *
     * Test if all the get parameters return the given construct values.
     *
     * @covers \ExtendsFramework\Console\Formatter\Color\Cyan\Cyan::getName()
     */
    public function testGetParameters(): void
    {
        $format = new Cyan();
        $name = $format->getName();

        $this->assertSame('Cyan', $name);
    }
}
