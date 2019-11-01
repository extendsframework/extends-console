<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Prompt\Question;

use ExtendsFramework\Console\Input\InputInterface;
use ExtendsFramework\Console\Output\OutputInterface;
use ExtendsFramework\Console\Prompt\PromptInterface;

class QuestionPrompt implements PromptInterface
{
    /**
     * Question to get answer for.
     *
     * @var string
     */
    private $question;

    /**
     * If an answer is required.
     *
     * @var bool
     */
    private $required;

    /**
     * Create new question prompt.
     *
     * @param string    $question
     * @param bool|null $required
     */
    public function __construct(string $question, bool $required = null)
    {
        $this->question = $question;
        $this->required = $required ?? true;
    }

    /**
     * @inheritDoc
     */
    public function prompt(InputInterface $input, OutputInterface $output): ?string
    {
        do {
            $output->text($this->question . ': ');
            $answer = $input->line();
        } while ($this->required && $answer === null);

        return $answer;
    }
}
