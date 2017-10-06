<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Shell\Command;

use ExtendsFramework\Console\Definition\DefinitionInterface;
use PHPUnit\Framework\TestCase;

class CommandTest extends TestCase
{
    /**
     * Get parameters.
     *
     * Test if all the get parameters return the given construct values.
     *
     * @covers \ExtendsFramework\Console\Shell\Command\Command::__construct()
     * @covers \ExtendsFramework\Console\Shell\Command\Command::getName()
     * @covers \ExtendsFramework\Console\Shell\Command\Command::getDescription()
     * @covers \ExtendsFramework\Console\Shell\Command\Command::getDefinition()
     */
    public function testGetParameters(): void
    {
        $definition = $this->createMock(DefinitionInterface::class);

        /**
         * @var DefinitionInterface $definition
         */
        $command = new Command('do.task', 'Some fancy task!', $definition);

        $this->assertSame('do.task', $command->getName());
        $this->assertSame('Some fancy task!', $command->getDescription());
        $this->assertSame($definition, $command->getDefinition());
    }
}
