<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Color\Yellow;

use PHPUnit\Framework\TestCase;

class YellowTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Formatter\Color\Yellow\Yellow::getName()
     */
    public function testCanGetName(): void
    {
        $format = new Yellow();
        $name = $format->getName();

        static::assertSame('Yellow', $name);
    }
}
