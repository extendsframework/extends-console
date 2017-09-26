<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Format\Underlined;

use PHPUnit\Framework\TestCase;

class UnderlinedTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Formatter\Format\Underlined\Underlined::getName()
     */
    public function testCanGetName(): void
    {
        $format = new Underlined();
        $name = $format->getName();

        static::assertSame('Underlined', $name);
    }
}
