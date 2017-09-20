<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Prompt;

use ExtendsFramework\Console\Input\InputException;
use ExtendsFramework\Console\Input\InputInterface;
use ExtendsFramework\Console\Output\OutputException;
use ExtendsFramework\Console\Output\OutputInterface;

interface PromptInterface
{
    /**
     * Show prompt.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return null|string
     * @throws PromptException|InputException|OutputException
     */
    public function prompt(InputInterface $input, OutputInterface $output): ?string;
}
