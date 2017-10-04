<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Shell;

use ExtendsFramework\Container\ContainerInterface;

interface ShellInterface
{
    /**
     * Match $arguments to corresponding command.
     *
     * When $arguments can not be matched, null will be returned.
     *
     * @param string[] $arguments
     * @return ContainerInterface|null
     */
    public function process(string ...$arguments): ?ContainerInterface;
}
