<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Input\Stream;

use ExtendsFramework\Console\Input\InputInterface;
use ExtendsFramework\Console\Input\Stream\Exception\InvalidStreamType;
use ExtendsFramework\Console\Input\Stream\Exception\StreamReadFailed;

class StreamInput implements InputInterface
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
     * @throws InvalidStreamType
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
    public function line(int $length = null): string
    {
        rewind($this->stream);

        $line = fgets($this->stream, $length ?? 4096);
        if ($line === false) {
            throw new StreamReadFailed();
        }

        return rtrim($line, "\n\r");
    }

    /**
     * @inheritDoc
     */
    public function character(string $allowed = null): string
    {
        rewind($this->stream);

        do {
            $character = fgetc($this->stream);
            $character = trim($character);
        } while ($character === '' || ($allowed && strpos($allowed, $character) === false));

        return $character;
    }
}
