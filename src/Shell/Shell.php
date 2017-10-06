<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Shell;

use ExtendsFramework\Console\Definition\Definition;
use ExtendsFramework\Console\Definition\DefinitionException;
use ExtendsFramework\Console\Definition\DefinitionInterface;
use ExtendsFramework\Console\Definition\Option\Option;
use ExtendsFramework\Console\Parser\ParserException;
use ExtendsFramework\Console\Parser\ParserInterface;
use ExtendsFramework\Console\Shell\Command\CommandInterface;
use ExtendsFramework\Console\Shell\Command\Suggester\SuggesterInterface;
use ExtendsFramework\Console\Shell\Descriptor\DescriptorInterface;
use ExtendsFramework\Console\Shell\Exception\CommandNotFound;

class Shell implements ShellInterface
{
    /**
     * Shell and command descriptor.
     *
     * @var DescriptorInterface
     */
    protected $descriptor;

    /**
     * Command suggester.
     *
     * @var SuggesterInterface
     */
    protected $suggester;

    /**
     * Parser to use for arguments.
     *
     * @var ParserInterface
     */
    protected $parser;

    /**
     * Shell definition for global options.
     *
     * @var DefinitionInterface
     */
    protected $definition;

    /**
     * Commands to iterate.
     *
     * @var CommandInterface[]
     */
    protected $commands;

    /**
     * Create a new Shell.
     *
     * @param DescriptorInterface $descriptor
     * @param SuggesterInterface  $suggester
     * @param ParserInterface     $parser
     */
    public function __construct(DescriptorInterface $descriptor, SuggesterInterface $suggester, ParserInterface $parser)
    {
        $this->descriptor = $descriptor;
        $this->suggester = $suggester;
        $this->parser = $parser;
        $this->commands = [];
    }

    /**
     * @inheritDoc
     */
    public function process(string ...$arguments): ?array
    {
        $definition = $this->getDefinition();

        try {
            $defaults = $this->parser->parse($definition, $arguments, false);
        } catch (ParserException | DefinitionException $exception) {
            $this->descriptor
                ->exception($exception)
                ->shell($definition, $this->commands, true);

            return null;
        }

        $remaining = $defaults->getRemaining();
        $parsed = $defaults->getParsed();

        $name = array_shift($remaining);
        if ($name === null) {
            $this->descriptor->shell($definition, $this->commands);

            return null;
        }

        try {
            $command = $this->getCommand($name);
        } catch (CommandNotFound $exception) {
            $this->descriptor
                ->exception($exception)
                ->suggest($this->suggester->suggest($name, ...$this->commands))
                ->shell($definition, $this->commands, true);

            return null;
        }

        $help = $parsed['help'] ?? false;
        if ($help === true) {
            $this->descriptor->command($command);

            return null;
        }

        try {
            $result = $this->parser->parse(
                $command->getDefinition(),
                $remaining
            );

            return $result->getParsed();
        } catch (ParserException | DefinitionException $exception) {
            $this->descriptor
                ->exception($exception)
                ->command($command, true);

            return null;
        }
    }

    /**
     * Add $command to shell.
     *
     * Commands will be processed in chronological order.
     *
     * @param CommandInterface $command
     * @return Shell
     */
    public function addCommand(CommandInterface $command): Shell
    {
        $this->commands[] = $command;

        return $this;
    }

    /**
     * Get command with $name.
     *
     * An exception will be thrown when command can not be found.
     *
     * @param string $name
     * @return CommandInterface
     * @throws CommandNotFound
     */
    protected function getCommand(string $name): CommandInterface
    {
        foreach ($this->commands as $command) {
            if ($command->getName() === $name) {
                return $command;
            }
        }

        throw new CommandNotFound($name);
    }

    /**
     * Get definition for default options.
     *
     * @return DefinitionInterface
     */
    protected function getDefinition(): DefinitionInterface
    {
        if ($this->definition === null) {
            $this->definition = (new Definition())
                ->addOption(new Option('help', 'Show help about shell or command.', 'h', 'help'));
        }

        return $this->definition;
    }
}
