<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Terminal;

interface TerminalInterface
{
    /**
     * Run terminal.
     *
     * @return void
     */
    public function run(): void;
}
