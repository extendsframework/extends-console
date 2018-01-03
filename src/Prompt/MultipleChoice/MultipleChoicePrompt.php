<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Prompt\MultipleChoice;

use ExtendsFramework\Console\Formatter\Color\Yellow\Yellow;
use ExtendsFramework\Console\Input\InputInterface;
use ExtendsFramework\Console\Output\OutputInterface;
use ExtendsFramework\Console\Prompt\PromptInterface;

class MultipleChoicePrompt implements PromptInterface
{
    /**
     * Question to get option for.
     *
     * @var string
     */
    protected $question;

    /**
     * Valid options to answer for question.
     *
     * @var array
     */
    protected $options;

    /**
     * If an answer is required.
     *
     * @var bool
     */
    protected $required;

    /**
     * Create new multiple choice prompt.
     *
     * @param string $question
     * @param array  $options
     */
    public function __construct(string $question, array $options)
    {
        $this->question = $question;
        $this->options = $options;

        $this->setRequired();
    }

    /**
     * @inheritDoc
     */
    public function prompt(InputInterface $input, OutputInterface $output): ?string
    {
        do {
            $output
                ->text($this->getQuestion() . ' ')
                ->text(
                    sprintf('[%s]', implode(',', $this->getOptions())),
                    $output
                        ->getFormatter()
                        ->setForeground(new Yellow())
                )
                ->text(': ');

            $option = $input->character();
        } while ($this->isValidOption($option) === false);

        return $option;
    }

    /**
     * Set required flag.
     *
     * When $required is true, a valid option must be chosen. Default value is true.
     *
     * @param bool|null $flag
     * @return MultipleChoicePrompt
     */
    public function setRequired(bool $flag = null): MultipleChoicePrompt
    {
        $this->required = $flag ?? true;

        return $this;
    }

    /**
     * Check if $option is an valid answer.
     *
     * @param null|string $option
     * @return bool
     */
    protected function isValidOption(?string $option): bool
    {
        return in_array($option, $this->getOptions(), true) === true
            || ($this->isRequired() === false && $option === null);
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
     * Get options.
     *
     * @return array
     */
    protected function getOptions(): array
    {
        return $this->options;
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
