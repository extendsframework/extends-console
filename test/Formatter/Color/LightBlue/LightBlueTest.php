<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Color\LightBlue;

use PHPUnit\Framework\TestCase;

class LightBlueTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Formatter\Color\LightBlue\LightBlue::getName()
     */
    public function testCanGetName(): void
    {
        $format = new LightBlue();
        $name = $format->getName();

        static::assertSame('LightBlue', $name);
    }
}
