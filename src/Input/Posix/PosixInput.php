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
        $handle = fopen('php://stdin', 'rb');
        $line = fgets($handle, $length ?? 4096);

        fclose($handle);

        return rtrim($line, "\n\r") ?: null;
    }

    /**
     * @inheritDoc
     */
    public function character(string $allowed = null): ?string
    {
        $handle = fopen('php://stdin', 'rb');
        $character = fgetc($handle);

        if ($allowed && strpos($allowed, $character) === false) {
            $character = '';
        }

        fclose($handle);

        return rtrim($character, "\n\r") ?: null;
    }
}
