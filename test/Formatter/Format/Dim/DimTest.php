<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Format\Dim;

use PHPUnit\Framework\TestCase;

class DimTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Formatter\Format\Dim\Dim::getName()
     */
    public function testCanGetName(): void
    {
        $format = new Dim();
        $name = $format->getName();

        static::assertSame('Dim', $name);
    }
}
