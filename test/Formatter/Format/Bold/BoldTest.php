<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Format\Bold;

use PHPUnit\Framework\TestCase;

class BoldTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Formatter\Format\Bold\Bold::getName()
     */
    public function testCanGetName(): void
    {
        $format = new Bold();
        $name = $format->getName();

        static::assertSame('Bold', $name);
    }
}
