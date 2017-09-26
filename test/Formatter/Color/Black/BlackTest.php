<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Color\Black;

use PHPUnit\Framework\TestCase;

class BlackTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Formatter\Color\Black\Black::getName()
     */
    public function testCanGetName(): void
    {
        $format = new Black();
        $name = $format->getName();

        static::assertSame('Black', $name);
    }
}
