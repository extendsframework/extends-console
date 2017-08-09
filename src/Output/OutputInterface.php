<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Output;

interface OutputInterface
{
    /**
     * Print text.
     *
     * When $newline is true, a newline will be added.
     *
     * @param string    $text
     * @param bool|null $newline
     * @return OutputInterface
     * @throws OutputException
     */
    public function text(string $text, bool $newline = null): OutputInterface;

    /**
     * Print $text including a new line.
     *
     * @param string[] ...$lines
     * @return OutputInterface
     * @throws OutputException
     */
    public function line(string ...$lines): OutputInterface;

    /**
     * Print $text as a paragraph with a max line length of $width.
     *
     * @param string $text
     * @param int    $width
     * @return OutputInterface
     * @throws OutputException
     */
    public function paragraph(string $text, int $width = null): OutputInterface;
}
