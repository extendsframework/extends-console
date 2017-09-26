<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Color\White;

use PHPUnit\Framework\TestCase;

class WhiteTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Formatter\Color\White\White::getName()
     */
    public function testCanGetName(): void
    {
        $format = new White();
        $name = $format->getName();

        static::assertSame('White', $name);
    }
}
