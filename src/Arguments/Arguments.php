<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Arguments;

class Arguments implements ArgumentsInterface
{
    /**
     * Command name,
     *
     * @var string|null
     */
    protected $command;

    /**
     * Arguments to iterate.
     *
     * @var array
     */
    protected $arguments;

    /**
     * Create new Arguments with $arguments.
     *
     * @param string[] $arguments
     */
    public function __construct(string ...$arguments)
    {
        $arguments = array_values($arguments);

        $this->command = array_shift($arguments);
        $this->arguments = $arguments;
    }

    /**
     * @inheritDoc
     */
    public function getCommand(): ?string
    {
        return $this->command;
    }

    /**
     * @inheritDoc
     */
    public function hasArgument(string ...$option): bool
    {
        foreach ($this->arguments as $argument) {
            if (in_array($argument, $option, true)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function current(): string
    {
        return current($this->arguments);
    }

    /**
     * @inheritDoc
     */
    public function next(): void
    {
        next($this->arguments);
    }

    /**
     * @inheritDoc
     */
    public function key(): int
    {
        return key($this->arguments);
    }

    /**
     * @inheritDoc
     */
    public function valid(): bool
    {
        return key($this->arguments) !== null;
    }

    /**
     * @inheritDoc
     */
    public function rewind(): void
    {
        reset($this->arguments);
    }
}
