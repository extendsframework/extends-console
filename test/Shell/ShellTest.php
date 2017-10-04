<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Shell;

use PHPUnit\Framework\TestCase;

class ShellTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Shell\Shell::__construct()
     * @covers \ExtendsFramework\Console\Shell\Shell::addCommand()
     * @covers \ExtendsFramework\Console\Shell\Shell::process()
     * @covers \ExtendsFramework\Console\Shell\Shell::getDescriptor()
     * @covers \ExtendsFramework\Console\Shell\Shell::getDefinition()
     */
    public function testCanParseArgumentsAndReturnContainer(): void
    {
    }

    /**
     * @covers \ExtendsFramework\Console\Shell\Shell::__construct()
     * @covers \ExtendsFramework\Console\Shell\Shell::addCommand()
     * @covers \ExtendsFramework\Console\Shell\Shell::process()
     * @covers \ExtendsFramework\Console\Shell\Shell::getDescriptor()
     * @covers \ExtendsFramework\Console\Shell\Shell::getDefinition()
     */
    public function testCanMatchCommandAndDescribeCommand(): void
    {
    }

    /**
     * @covers \ExtendsFramework\Console\Shell\Shell::__construct()
     * @covers \ExtendsFramework\Console\Shell\Shell::addCommand()
     * @covers \ExtendsFramework\Console\Shell\Shell::process()
     * @covers \ExtendsFramework\Console\Shell\Shell::getDescriptor()
     * @covers \ExtendsFramework\Console\Shell\Shell::getDefinition()
     */
    public function testCanCatchParserExceptionAndDescribeCommand(): void
    {
    }

    /**
     * @covers \ExtendsFramework\Console\Shell\Shell::__construct()
     * @covers \ExtendsFramework\Console\Shell\Shell::addCommand()
     * @covers \ExtendsFramework\Console\Shell\Shell::process()
     * @covers \ExtendsFramework\Console\Shell\Shell::getDescriptor()
     * @covers \ExtendsFramework\Console\Shell\Shell::getDefinition()
     */
    public function testCanNotMatchCommandAndDescribeShell(): void
    {
    }
}
