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
     * @param string $question
     */
    public function __construct(string $question)
    {
        $this->question = $question;

        $this->setRequired();
    }

    /**
     * @inheritDoc
     */
    public function prompt(InputInterface $input, OutputInterface $output): ?string
    {
        do {
            $output->text($this->getQuestion() . ': ');
            $answer = $input->line();
        } while ($this->isRequired() === true && $answer === null);

        return $answer;
    }

    /**
     * Set required flag.
     *
     * When $required is true, the question must be answered. Default value is true.
     *
     * @param bool|null $flag
     * @return QuestionPrompt
     */
    public function setRequired(bool $flag = null): QuestionPrompt
    {
        $this->required = $flag ?? true;

        return $this;
    }

    /**
     * Get question.
     *
     * @return string
     */
    protected function getQuestion(): string
    {
        return $this->question;
    }

    /**
     * Get required.
     *
     * @return bool
     */
    protected function isRequired(): bool
    {
        return $this->required;
    }
}
