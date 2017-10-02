<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Definition\Option;

use PHPUnit\Framework\TestCase;

class OptionTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Definition\Option\Option::__construct()
     * @covers \ExtendsFramework\Console\Definition\Option\Option::getName()
     * @covers \ExtendsFramework\Console\Definition\Option\Option::getShort()
     * @covers \ExtendsFramework\Console\Definition\Option\Option::getLong()
     * @covers \ExtendsFramework\Console\Definition\Option\Option::isFlag()
     * @covers \ExtendsFramework\Console\Definition\Option\Option::isMultiple()
     */
    public function testCanConstructAndGetParameters(): void
    {
        $option = new Option('fooBar', 'f', 'foo-bar', true, true);

        $this->assertSame('fooBar', $option->getName());
        $this->assertSame('f', $option->getShort());
        $this->assertSame('foo-bar', $option->getLong());
        $this->assertSame(true, $option->isFlag());
        $this->assertSame(true, $option->isMultiple());
    }

    /**
     * @covers                   \ExtendsFramework\Console\Definition\Option\Option::__construct()
     * @covers                   \ExtendsFramework\Console\Definition\Option\Exception\NoShortAndLongName::__construct
     * @expectedException        \ExtendsFramework\Console\Definition\Option\Exception\NoShortAndLongName
     * @expectedExceptionMessage Option "fooBar" requires at least a short or long name, both not given.
     */
    public function testCanNotConstructWithoutShortAndLong(): void
    {
        new Option('fooBar', null, null, true, true);
    }
}
