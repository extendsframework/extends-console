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
     * When $required is true, a valid option must be chosen. Default value is true.
     *
     * @param string    $question
     * @param array     $options
     * @param bool|null $required
     */
    public function __construct(string $question, array $options, bool $required = null)
    {
        $this->question = $question;
        $this->options = $options;
        $this->required = $required ?? true;
    }

    /**
     * @inheritDoc
     */
    public function prompt(InputInterface $input, OutputInterface $output): ?string
    {
        do {
            $output
                ->text($this->question . ' ')
                ->text(
                    sprintf('[%s]', implode(',', $this->options)),
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
