<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Shell\Command;

use ExtendsFramework\Console\Definition\DefinitionInterface;

interface CommandInterface
{
    /**
     * Get name.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription(): string;

    /**
     * Get definition.
     *
     * @return DefinitionInterface
     */
    public function getDefinition(): DefinitionInterface;
}
