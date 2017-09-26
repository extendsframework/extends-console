<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Format\Reverse;

use PHPUnit\Framework\TestCase;

class ReverseTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Formatter\Format\Reverse\Reverse::getName()
     */
    public function testCanGetName(): void
    {
        $format = new Reverse();
        $name = $format->getName();

        static::assertSame('Reverse', $name);
    }
}
