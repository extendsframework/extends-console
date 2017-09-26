<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Color\Magenta;

use PHPUnit\Framework\TestCase;

class MagentaTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Formatter\Color\Magenta\Magenta::getName()
     */
    public function testCanGetName(): void
    {
        $format = new Magenta();
        $name = $format->getName();

        static::assertSame('Magenta', $name);
    }
}
