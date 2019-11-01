<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Prompt\MultipleChoice;

use ExtendsFramework\Console\Formatter\Color\Yellow\Yellow;
use ExtendsFramework\Console\Formatter\FormatterException;
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
    private $question;

    /**
     * Valid options to answer for question.
     *
     * @var array
     */
    private $options;

    /**
     * If an answer is required.
     *
     * @var bool
     */
    private $required;

    /**
     * Create new multiple choice prompt.
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
     * @throws FormatterException
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
        } while (!in_array($option, $this->options, true) && $this->required && $option === null);

        return $option;
    }
}
