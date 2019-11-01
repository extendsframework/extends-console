<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Input\Posix;

use ExtendsFramework\Console\Input\InputInterface;

class PosixInput implements InputInterface
{
    /**
     * @inheritDoc
     */
    public function line(int $length = null): ?string
    {
        $line = fgets(STDIN, $length ?? 4096);

        return rtrim($line, "\n\r") ?: null;
    }

    /**
     * @inheritDoc
     */
    public function character(string $allowed = null): ?string
    {
        $character = fgetc(STDIN);
        if (is_string($allowed) && strpos($allowed, $character) === false) {
            $character = '';
        }

        return rtrim($character, "\n\r") ?: null;
    }
}
