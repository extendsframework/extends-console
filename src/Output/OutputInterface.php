<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Output;

interface OutputInterface
{
    /**
     * Send $text to output.
     *
     * @param string $text
     * @return OutputInterface
     * @throws OutputException
     */
    public function text(string $text): OutputInterface;

    /**
     * Send $lines to output.
     *
     * Ech line will be followed by a new line character.
     *
     * @param string[] ...$lines
     * @return OutputInterface
     */
    public function line(string ...$lines): OutputInterface;
}
