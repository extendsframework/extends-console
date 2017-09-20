<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Prompt\Question;

use ExtendsFramework\Console\Input\InputException;
use ExtendsFramework\Console\Input\InputInterface;
use ExtendsFramework\Console\Output\OutputException;
use ExtendsFramework\Console\Output\OutputInterface;
use ExtendsFramework\Console\Prompt\AbstractPrompt;
use ExtendsFramework\Console\Prompt\Question\Exception\QuestionPromptFailed;

class QuestionPrompt extends AbstractPrompt
{
    /**
     * Question to get answer for.
     *
     * @var string
     */
    protected $question;

    /**
     * Create new question prompt.
     *
     * When $required is true, the question must be answered. Default value is true.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @param string          $question
     * @param bool|null       $required
     */
    public function __construct(InputInterface $input, OutputInterface $output, string $question, bool $required = null)
    {
        parent::__construct($input, $output, $required);

        $this->question = $question;
    }

    /**
     * @inheritDoc
     */
    public function prompt(): ?string
    {
        do {
            try {
                $this->output->text($this->question . ': ');
                $answer = $this->input->line();
            } catch (InputException | OutputException $exception) {
                throw new QuestionPromptFailed('Failed to prompt question.', 0, $exception);
            }
        } while ($this->required === true && $answer === null);

        return $answer;
    }
}
