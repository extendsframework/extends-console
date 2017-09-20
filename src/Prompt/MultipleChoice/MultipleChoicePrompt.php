<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Prompt\MultipleChoice;

use ExtendsFramework\Console\Input\InputException;
use ExtendsFramework\Console\Input\InputInterface;
use ExtendsFramework\Console\Output\OutputException;
use ExtendsFramework\Console\Output\OutputInterface;
use ExtendsFramework\Console\Prompt\AbstractPrompt;
use ExtendsFramework\Console\Prompt\MultipleChoice\Exception\MultipleChoicePromptFailed;

class MultipleChoicePrompt extends AbstractPrompt
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
     * Create new multiple choice prompt.
     *
     * When $required is true, a valid option must be chosen. Default value is true.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @param string          $question
     * @param array           $options
     * @param bool|null       $required
     */
    public function __construct(InputInterface $input, OutputInterface $output, string $question, array $options, bool $required = null)
    {
        parent::__construct($input, $output, $required);

        $this->question = $question;
        $this->options = $options;
    }

    /**
     * @inheritDoc
     */
    public function prompt(): ?string
    {
        do {
            $question = sprintf(
                '%s [%s]: ',
                $this->question,
                implode(',', $this->options)
            );

            try {
                $this->output->text($question);
                $option = $this->input->character();
            } catch (InputException | OutputException $exception) {
                throw new MultipleChoicePromptFailed('Failed to prompt multiple choice question.', 0, $exception);
            }
        } while ($this->isValidOption($option) === false);

        return $option;
    }

    /**
     * Check if $option is an valid answer.
     *
     * @param null|string $option
     * @return bool
     */
    protected function isValidOption(?string $option): bool
    {
        return in_array($option, $this->options, true) === true || ($this->required === false || $option === null);
    }
}
