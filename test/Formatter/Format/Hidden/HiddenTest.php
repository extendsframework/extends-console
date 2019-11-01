<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Format\Hidden;

use PHPUnit\Framework\TestCase;

class HiddenTest extends TestCase
{
    /**
     * Get parameters.
     *
     * Test if all the get parameters return the given construct values.
     *
     * @covers \ExtendsFramework\Console\Formatter\Format\Hidden\Hidden::getName()
     */
    public function testGetParameters(): void
    {
        $format = new Hidden();
        $name = $format->getName();

        $this->assertSame('Hidden', $name);
    }
}
