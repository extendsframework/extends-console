<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Shell\Command;

use ExtendsFramework\Console\Definition\DefinitionInterface;

class Command implements CommandInterface
{
    /**
     * Command name.
     *
     * @var string
     */
    protected $name;

    /**
     * Command description.
     *
     * @var string
     */
    protected $description;

    /**
     * Command definition.
     *
     * @var DefinitionInterface
     */
    protected $definition;

    /**
     * Create new command for $name with $description and $definition.
     *
     * @param string              $name
     * @param string              $description
     * @param DefinitionInterface $definition
     */
    public function __construct(string $name, string $description, DefinitionInterface $definition)
    {
        $this->name = $name;
        $this->description = $description;
        $this->definition = $definition;
    }

    /**
     * /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @inheritDoc
     */
    public function getDefinition(): DefinitionInterface
    {
        return $this->definition;
    }

}
