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
     * Send $line to output.
     *
     * @param string $line
     * @return OutputInterface
     * @throws OutputException
     */
    public function line(string $line): OutputInterface;
}
