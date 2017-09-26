<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Output\Posix;

use ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter;
use ExtendsFramework\Console\Formatter\FormatterInterface;
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
     * Text formatter.
     *
     * @var FormatterInterface
     */
    protected $formatter;

    /**
     * Create new output stream with $resource.
     *
     * @param resource                $resource
     * @param FormatterInterface|null $formatter
     * @throws InvalidStreamType
     */
    public function __construct($resource, FormatterInterface $formatter = null)
    {
        if (is_resource($resource) === false || get_resource_type($resource) !== 'stream') {
            throw new InvalidStreamType($resource);
        }

        $this->stream = $resource;
        $this->formatter = $formatter ?: new AnsiFormatter();
    }

    /**
     * @inheritDoc
     */
    public function text(string $text, FormatterInterface $formatter = null): OutputInterface
    {
        if ($formatter) {
            $text = $formatter->create($text);
        }

        $bytes = @fwrite($this->stream, $text);
        if ($bytes === false) {
            throw new StreamWriteFailed();
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function line(string ...$lines): OutputInterface
    {
        foreach ($lines as $line) {
            $this
                ->text($line)
                ->newLine();
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function newLine(): OutputInterface
    {
        return $this->text("\n\r");
    }

    /**
     * @inheritDoc
     */
    public function getFormatter(): FormatterInterface
    {
        return $this->formatter;
    }
}
