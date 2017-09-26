<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Color\Green;

use PHPUnit\Framework\TestCase;

class GreenTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Formatter\Color\Green\Green::getName()
     */
    public function testCanGetName(): void
    {
        $format = new Green();
        $name = $format->getName();

        static::assertSame('Green', $name);
    }
}
