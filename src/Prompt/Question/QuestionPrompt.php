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
    protected $question;

    /**
     * If an answer is required.
     *
     * @var bool
     */
    protected $required;

    /**
     * Create new question prompt.
     *
     * When $required is true, the question must be answered. Default value is true.
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
        } while ($this->required === true && $answer === null);

        return $answer;
    }
}
