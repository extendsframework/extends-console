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
    private $formatter;

    /**
     * Output verbosity.
     *
     * @var int
     */
    private $verbosity = 1;

    /**
     * @inheritDoc
     */
    public function text(string $text, FormatterInterface $formatter = null, int $verbosity = null): OutputInterface
    {
        if (($verbosity ?? 1) <= $this->verbosity) {
            if ($formatter) {
                $text = $formatter->create($text);
            }

            fwrite(STDOUT, $text);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function line(string $text, FormatterInterface $formatter = null, int $verbosity = null): OutputInterface
    {
        return $this
            ->text($text, $formatter, $verbosity)
            ->newLine($verbosity);
    }

    /**
     * @inheritDoc
     */
    public function newLine(int $verbosity = null): OutputInterface
    {
        return $this->text("\n\r", null, $verbosity);
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
        if ($this->formatter === null) {
            $this->formatter = new AnsiFormatter();
        }

        return $this->formatter;
    }

    /**
     * @inheritDoc
     */
    public function setVerbosity(int $verbosity): OutputInterface
    {
        $this->verbosity = $verbosity;

        return $this;
    }

    /**
     * Set formatter.
     *
     * @param FormatterInterface $formatter
     * @return PosixOutput
     */
    public function setFormatter(FormatterInterface $formatter): PosixOutput
    {
        $this->formatter = $formatter;

        return $this;
    }
}
