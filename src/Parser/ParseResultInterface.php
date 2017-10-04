<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Parser;

use ExtendsFramework\Container\ContainerInterface;

interface ParseResultInterface
{
    /**
     * Get parsed data.
     *
     * @return ContainerInterface
     */
    public function getParsed(): ContainerInterface;

    /**
     * Get remaining data when not in strict mode.
     *
     * @return ContainerInterface
     */
    public function getRemaining(): ContainerInterface;

    /**
     * If parsing was done in strict mode.
     *
     * @return bool
     */
    public function isStrict(): bool;
}
