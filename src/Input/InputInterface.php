<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Input;

interface InputInterface
{
    /**
     * Read a line from the input.
     *
     * Reading will stop when $length or end of line is reached.
     *
     * @param int|null $length
     * @return null|string
     * @throws InputException
     */
    public function line(int $length = null): ?string;

    /**
     * Read a character from the input.
     *
     * Characters in $allowed are allowed, else every character is allowed.
     *
     * @param string|null $allowed
     * @return null|string
     * @throws InputException
     */
    public function character(string $allowed = null): ?string;
}
