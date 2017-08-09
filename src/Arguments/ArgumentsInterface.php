<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Arguments;

use Iterator;

interface ArgumentsInterface extends Iterator
{
    /**
     * Get command name from arguments.
     *
     * @return string
     */
    public function getCommand(): ?string;

    /**
     * Check if argument(s) exist.
     *
     * Combined arguments are ignored.
     *
     * @param string[] $option
     * @return bool
     */
    public function hasArgument(string ...$option): bool;
}
