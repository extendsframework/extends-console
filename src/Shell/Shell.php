<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Shell;

use ExtendsFramework\Console\Definition\Definition;
use ExtendsFramework\Console\Definition\DefinitionException;
use ExtendsFramework\Console\Definition\DefinitionInterface;
use ExtendsFramework\Console\Definition\Option\Option;
use ExtendsFramework\Console\Output\OutputInterface;
use ExtendsFramework\Console\Parser\ParserException;
use ExtendsFramework\Console\Parser\ParserInterface;
use ExtendsFramework\Console\Shell\Command\CommandInterface;
use ExtendsFramework\Console\Shell\Command\Suggester\SimilarText\SimilarTextSuggester;
use ExtendsFramework\Console\Shell\Command\Suggester\SuggesterInterface;
use ExtendsFramework\Console\Shell\Descriptor\Descriptor;
use ExtendsFramework\Console\Shell\Descriptor\DescriptorInterface;
use ExtendsFramework\Console\Shell\Exception\CommandNotFound;
use ExtendsFramework\Container\ContainerInterface;

class Shell implements ShellInterface
{
    /**
     * Output to use for descriptor.
     *
     * @var OutputInterface
     */
    protected $output;

    /**
     * Parser to use for arguments.
     *
     * @var ParserInterface
     */
    protected $parser;

    /**
     * Commands to iterate.
     *
     * @var CommandInterface[]
     */
    protected $commands;

    /**
     * Shell definition for global options.
     *
     * @var DefinitionInterface
     */
    protected $definition;

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
     * Create a new Shell.
     *
     * @param OutputInterface $output
     * @param ParserInterface $parser
     */
    public function __construct(OutputInterface $output, ParserInterface $parser)
    {
        $this->output = $output;
        $this->parser = $parser;
        $this->commands = [];
    }

    /**
     * @inheritDoc
     */
    public function process(string ...$arguments): ?ContainerInterface
    {
        $definition = $this->getDefinition();
        $descriptor = $this->getDescriptor();
        $suggester = $this->getSuggester();

        try {
            $defaults = $this->parser->parse($definition, $arguments, false);
        } catch (ParserException | DefinitionException $exception) {
            $descriptor
                ->exception($exception)
                ->shell($definition, $this->commands, true);

            return null;
        }

        $remaining = $defaults->getRemaining()->extract();
        $name = array_shift($remaining);
        if ($name === null) {
            $descriptor->shell($definition, $this->commands);

            return null;
        }

        try {
            $command = $this->getCommand($name);
        } catch (CommandNotFound $exception) {
            $descriptor
                ->exception($exception)
                ->suggest($suggester->suggest($name, ...$this->commands))
                ->shell($definition, $this->commands, true);

            return null;
        }

        $help = $defaults->getParsed()->find('help', false);
        if ($help === true) {
            $descriptor->command($command);

            return null;
        }

        try {
            $result = $this->parser->parse(
                $command->getDefinition(),
                $remaining
            );

            return $result->getParsed();
        } catch (ParserException | DefinitionException $exception) {
            $descriptor
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
                ->addOption(new Option('verbose', 'Be more verbose.', 'v', null, true, true))
                ->addOption(new Option('quit', 'Only output exception.', null, 'quit', false))
                ->addOption(new Option('silent', 'Sstt.. don\'t output anything.', null, 'silent'))
                ->addOption(new Option('help', 'Show help about shell or command.', 'h', 'help'));
        }

        return $this->definition;
    }

    /**
     * Get descriptor.
     *
     * @return DescriptorInterface
     */
    protected function getDescriptor(): DescriptorInterface
    {
        if ($this->descriptor === null) {
            $this->descriptor = new Descriptor(
                $this->output,
                'Extends Framework Console',
                'extends',
                '0.1'
            );
        }

        return $this->descriptor;
    }

    /**
     * Get command suggester.
     *
     * @return SuggesterInterface
     */
    protected function getSuggester(): SuggesterInterface
    {
        if ($this->suggester === null) {
            $this->suggester = new SimilarTextSuggester();
        }

        return $this->suggester;
    }
}
