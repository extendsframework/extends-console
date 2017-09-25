<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Output;

use ExtendsFramework\Console\Formatter\FormatterInterface;

interface OutputInterface
{
    /**
     * Send $text to output.
     *
     * @param string                  $text
     * @param FormatterInterface|null $formatter
     * @return OutputInterface
     */
    public function text(string $text, FormatterInterface $formatter = null): OutputInterface;

    /**
     * Send $lines to output.
     *
     * Ech line will be followed by a new line character.
     *
     * @param string[] ...$lines
     * @return OutputInterface
     * @throws OutputException
     */
    public function line(string ...$lines): OutputInterface;

    /**
     * Send new line to output.
     *
     * @return OutputInterface
     */
    public function newLine(): OutputInterface;

    /**
     * Get new builder to format text.
     *
     * @return FormatterInterface
     */
    public function getFormatter(): FormatterInterface;
}
