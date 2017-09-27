<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Output\Posix;

use ExtendsFramework\Console\Formatter\Ansi\AnsiFormatter;
use ExtendsFramework\Console\Formatter\FormatterInterface;
use ExtendsFramework\Console\Output\OutputInterface;

class PosixOutput implements OutputInterface
{
    /**
     * Text formatter.
     *
     * @var FormatterInterface
     */
    protected $formatter;

    /**
     * Create new output stream with $resource.
     *
     * @param FormatterInterface|null $formatter
     */
    public function __construct(FormatterInterface $formatter = null)
    {
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

        $handle = fopen('php://stdout', 'wb');
        fwrite($handle, $text);
        fclose($handle);

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
    public function clear(): OutputInterface
    {
        system('tput clear');

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getColumns(): int
    {
        return (int)exec('tput cols');
    }

    /**
     * @inheritDoc
     */
    public function getLines(): int
    {
        return (int)exec('tput lines');
    }

    /**
     * @inheritDoc
     */
    public function getFormatter(): FormatterInterface
    {
        return $this->formatter;
    }
}
