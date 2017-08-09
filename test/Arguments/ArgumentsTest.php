<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Arguments;

use PHPUnit\Framework\TestCase;

class ArgumentsTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Arguments\Arguments::__construct()
     * @covers \ExtendsFramework\Console\Arguments\Arguments::rewind()
     * @covers \ExtendsFramework\Console\Arguments\Arguments::valid()
     * @covers \ExtendsFramework\Console\Arguments\Arguments::key()
     * @covers \ExtendsFramework\Console\Arguments\Arguments::current()
     * @covers \ExtendsFramework\Console\Arguments\Arguments::next()
     */
    public function testCanIterateArguments(): void
    {
        $iterated = [];
        $arguments = new Arguments(...[
            'command_name',
            '-f',
            'foo',
            'bar',
        ]);
        foreach ($arguments as $index => $argument) {
            $iterated[$index] = $argument;
        }

        $this->assertSame([
            '-f',
            'foo',
            'bar',
        ], $iterated);
    }

    /**
     * @covers \ExtendsFramework\Console\Arguments\Arguments::__construct()
     * @covers \ExtendsFramework\Console\Arguments\Arguments::getCommand()
     */
    public function testCanGetCommand(): void
    {
        $arguments = new Arguments(...[
            'command_name',
            '-f',
            'foo',
            'bar',
        ]);
        $command = $arguments->getCommand();

        $this->assertSame('command_name', $command);
    }

    /**
     * @covers \ExtendsFramework\Console\Arguments\Arguments::__construct()
     * @covers \ExtendsFramework\Console\Arguments\Arguments::getCommand()
     */
    public function testCanNotGetCommandForEmptyArguments(): void
    {
        $arguments = new Arguments();

        $this->assertNull($arguments->getCommand());
    }

    /**
     * @covers \ExtendsFramework\Console\Arguments\Arguments::__construct()
     * @covers \ExtendsFramework\Console\Arguments\Arguments::hasArgument()
     */
    public function testCanCheckIfContainsArgument(): void
    {
        $arguments = new Arguments(...[
            'command_name',
            '-h',
            '--help',
        ]);

        $this->assertTrue($arguments->hasArgument('-h', '--help'));
        $this->assertFalse($arguments->hasArgument('--version'));
    }
}
