<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Formatter\Format\Hidden;

use PHPUnit\Framework\TestCase;

class HiddenTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Formatter\Format\Hidden\Hidden::getName()
     */
    public function testCanGetName(): void
    {
        $format = new Hidden();
        $name = $format->getName();

        static::assertSame('Hidden', $name);
    }
}
