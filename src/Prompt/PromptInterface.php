<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Prompt;

interface PromptInterface
{
    /**
     * Show prompt.
     *
     * @return null|string
     * @throws PromptException
     */
    public function prompt(): ?string;
}
