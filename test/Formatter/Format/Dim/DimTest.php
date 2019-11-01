<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Format\Dim;

use PHPUnit\Framework\TestCase;

class DimTest extends TestCase
{
    /**
     * Get parameters.
     *
     * Test if all the get parameters return the given construct values.
     *
     * @covers \ExtendsFramework\Console\Formatter\Format\Dim\Dim::getName()
     */
    public function testGetParameters(): void
    {
        $format = new Dim();
        $name = $format->getName();

        $this->assertSame('Dim', $name);
    }
}
