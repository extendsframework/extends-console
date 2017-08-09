<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Output;

use ExtendsFramework\Console\Output\Adapter\AdapterInterface;

class Output implements OutputInterface
{
    /**
     * Adapter to write.
     *
     * @var AdapterInterface
     */
    protected $adapter;

    /**
     * Create new Output with $adapter.
     *
     * @param AdapterInterface $adapter
     */
    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @inheritDoc
     */
    public function text(string $text, bool $newline = null): OutputInterface
    {
        if ($newline) {
            $text .= PHP_EOL;
        }

        $this->adapter->write($text);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function line(string ...$lines): OutputInterface
    {
        foreach ($lines as $line) {
            $this->text($line, true);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function paragraph(string $text, int $width = null): OutputInterface
    {
        $text = wordwrap($text, $width ?? 75, PHP_EOL, true);

        return $this->text($text, true);
    }
}
