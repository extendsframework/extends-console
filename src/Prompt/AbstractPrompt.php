<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Prompt;

use ExtendsFramework\Console\Input\InputInterface;
use ExtendsFramework\Console\Output\OutputInterface;

abstract class AbstractPrompt implements PromptInterface
{
    /**
     * Input to read from.
     *
     * @var InputInterface
     */
    protected $input;

    /**
     * Output to write to.
     *
     * @var OutputInterface
     */
    protected $output;

    /**
     * If this prompt is required to answer.
     *
     * @var bool
     */
    protected $required;

    /**
     * Create a new abstract prompt.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @param bool|null       $required
     */
    public function __construct(InputInterface $input, OutputInterface $output, bool $required = null)
    {
        $this->input = $input;
        $this->output = $output;
        $this->required = $required ?? true;
    }
}
