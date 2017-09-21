<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Input\Posix;

use ExtendsFramework\Console\Input\InputException;
use ExtendsFramework\Console\Input\InputInterface;
use ExtendsFramework\Console\Input\Posix\Exception\InvalidStreamType;
use ExtendsFramework\Console\Input\Posix\Exception\StreamReadFailed;

class PosixInput implements InputInterface
{
    /**
     * Resource to read from.
     *
     * @var resource
     */
    protected $stream;

    /**
     * Create new input stream with $resource.
     *
     * @param resource $resource
     * @throws InputException
     */
    public function __construct($resource)
    {
        if (is_resource($resource) === false || get_resource_type($resource) !== 'stream') {
            throw new InvalidStreamType($resource);
        }

        $this->stream = $resource;
    }

    /**
     * @inheritDoc
     */
    public function line(int $length = null): ?string
    {
        rewind($this->stream);

        $line = fgets($this->stream, $length ?? 4096);
        if ($line === false) {
            throw new StreamReadFailed();
        }

        return rtrim($line, "\n\r") ?: null;
    }

    /**
     * @inheritDoc
     */
    public function character(string $allowed = null): ?string
    {
        rewind($this->stream);

        $character = fgetc($this->stream);
        if ($character === false) {
            throw new StreamReadFailed();
        }

        if ($allowed && strpos($allowed, $character) === false) {
            $character = '';
        }

        return rtrim($character, "\n\r") ?: null;
    }
}
