<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Output\Posix;

use ExtendsFramework\Console\Output\OutputInterface;
use ExtendsFramework\Console\Output\Posix\Exception\InvalidStreamType;
use ExtendsFramework\Console\Output\Posix\Exception\StreamWriteFailed;

class PosixOutput implements OutputInterface
{
    /**
     * Resource to write to.
     *
     * @var resource
     */
    protected $stream;

    /**
     * Create new output stream with $resource.
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
    public function text(string $text): OutputInterface
    {
        $bytes = @fwrite($this->stream, $text);
        if ($bytes === false) {
            throw new StreamWriteFailed();
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function line(string $line): OutputInterface
    {
        return $this->text($line . "\n\r");
    }
}
