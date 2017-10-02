<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Definition\Option;

use PHPUnit\Framework\TestCase;

class OptionTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Definition\Option\Option::__construct()
     * @covers \ExtendsFramework\Console\Definition\Option\Option::getName()
     * @covers \ExtendsFramework\Console\Definition\Option\Option::getDescription()
     * @covers \ExtendsFramework\Console\Definition\Option\Option::getShort()
     * @covers \ExtendsFramework\Console\Definition\Option\Option::getLong()
     * @covers \ExtendsFramework\Console\Definition\Option\Option::isFlag()
     * @covers \ExtendsFramework\Console\Definition\Option\Option::isMultiple()
     */
    public function testCanConstructAndGetParameters(): void
    {
        $option = new Option('fooBar', 'Some description.', 'f', 'foo-bar', true, true);

        static::assertSame('fooBar', $option->getName());
        static::assertSame('Some description.', $option->getDescription());
        static::assertSame('f', $option->getShort());
        static::assertSame('foo-bar', $option->getLong());
        static::assertSame(true, $option->isFlag());
        static::assertSame(true, $option->isMultiple());
    }

    /**
     * @covers                   \ExtendsFramework\Console\Definition\Option\Option::__construct()
     * @covers                   \ExtendsFramework\Console\Definition\Option\Exception\NoShortAndLongName::__construct
     * @expectedException        \ExtendsFramework\Console\Definition\Option\Exception\NoShortAndLongName
     * @expectedExceptionMessage Option "fooBar" requires at least a short or long name, both not given.
     */
    public function testCanNotConstructWithoutShortAndLong(): void
    {
        new Option('fooBar', 'Some description.', null, null, true, true);
    }
}
