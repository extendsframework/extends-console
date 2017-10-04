<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Parser;

use ExtendsFramework\Container\ContainerInterface;

class ParseResult implements ParseResultInterface
{
    /**
     * Parsed data.
     *
     * @var ContainerInterface
     */
    protected $parsed;

    /**
     * Remaining data when not in strict mode.
     *
     * @var ContainerInterface
     */
    protected $remaining;

    /**
     * If parsing was done in strict mode.
     *
     * @var bool
     */
    protected $strict;

    /**
     * Create new parse result.
     *
     * @param ContainerInterface $parsed
     * @param ContainerInterface $remaining
     * @param bool               $strict
     */
    public function __construct(ContainerInterface $parsed, ContainerInterface $remaining, bool $strict)
    {
        $this->parsed = $parsed;
        $this->remaining = $remaining;
        $this->strict = $strict;
    }

    /**
     * @inheritDoc
     */
    public function getParsed(): ContainerInterface
    {
        return $this->parsed;
    }

    /**
     * @inheritDoc
     */
    public function getRemaining(): ContainerInterface
    {
        return $this->remaining;
    }

    /**
     * @inheritDoc
     */
    public function isStrict(): bool
    {
        return $this->strict;
    }
}
