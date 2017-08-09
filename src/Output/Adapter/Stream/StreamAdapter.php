<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Output\Adapter\Stream;

use ExtendsFramework\Console\Output\Adapter\AdapterInterface;
use ExtendsFramework\Console\Output\Adapter\Stream\Exception\InvalidResourceType;
use ExtendsFramework\Console\Output\Adapter\Stream\Exception\StreamWriteFailed;

class StreamAdapter implements AdapterInterface
{
    /**
     * Stream to write.
     *
     * @var resource
     */
    protected $stream;

    /**
     * Create new StreamOutput with $stream.
     *
     * @param resource $stream
     * @throws InvalidResourceType
     */
    public function __construct($stream)
    {
        if (!is_resource($stream)) {
            throw new InvalidResourceType($stream);
        }

        $this->stream = $stream;
    }

    /**
     * @inheritDoc
     */
    public function write(string $text): AdapterInterface
    {
        $bytes = @fwrite($this->stream, $text);
        if ($bytes === false) {
            $error = error_get_last();

            throw new StreamWriteFailed($text, $error['message']);
        }

        fflush($this->stream);

        return $this;
    }
}
