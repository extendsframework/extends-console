<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Color\LightGreen;

use PHPUnit\Framework\TestCase;

class LightGreenTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Formatter\Color\LightGreen\LightGreen::getName()
     */
    public function testCanGetName(): void
    {
        $format = new LightGreen();
        $name = $format->getName();

        static::assertSame('LightGreen', $name);
    }
}
