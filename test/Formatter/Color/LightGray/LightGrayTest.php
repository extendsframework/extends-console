<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Color\LightGray;

use PHPUnit\Framework\TestCase;

class LightGrayTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Formatter\Color\LightGray\LightGray::getName()
     */
    public function testCanGetName(): void
    {
        $format = new LightGray();
        $name = $format->getName();

        static::assertSame('LightGray', $name);
    }
}
