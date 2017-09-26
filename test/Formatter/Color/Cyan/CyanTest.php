<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Color\Cyan;

use PHPUnit\Framework\TestCase;

class CyanTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Formatter\Color\Cyan\Cyan::getName()
     */
    public function testCanGetName(): void
    {
        $format = new Cyan();
        $name = $format->getName();

        static::assertSame('Cyan', $name);
    }
}
