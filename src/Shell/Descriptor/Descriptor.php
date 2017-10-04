<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Shell\Descriptor;

use ExtendsFramework\Console\Definition\DefinitionInterface;
use ExtendsFramework\Console\Definition\Option\OptionInterface;
use ExtendsFramework\Console\Formatter\Color\Red\Red;
use ExtendsFramework\Console\Formatter\Color\Yellow\Yellow;
use ExtendsFramework\Console\Output\OutputInterface;
use ExtendsFramework\Console\Shell\Command\CommandInterface;
use Throwable;

class Descriptor implements DescriptorInterface
{
    /**
     * Output to send description to.
     *
     * @var OutputInterface
     */
    protected $output;

    /**
     * Full shell name.
     *
     * @var string
     */
    protected $name;

    /**
     * Program name to run this shell.
     *
     * @var string
     */
    protected $program;

    /**
     * Shell version.
     *
     * @var string
     */
    protected $version;

    /**
     * Create a new descriptor.
     *
     * @param OutputInterface $output
     * @param string          $name
     * @param string          $program
     * @param string          $version
     */
    public function __construct(OutputInterface $output, string $name, string $program, string $version)
    {
        $this->output = $output;
        $this->name = $name;
        $this->program = $program;
        $this->version = $version;
    }

    /**
     * @inheritDoc
     */
    public function shell(DefinitionInterface $definition, array $commands, bool $short = null): DescriptorInterface
    {
        $output = $this->output;
        $formatter = $output->getFormatter();

        if ($short === true) {
            $output
                ->newLine()
                ->line(sprintf(
                    'See \'%s --help\' for more information about available commands and options.',
                    $this->program
                ));

            return $this;
        }

        $output
            ->line(sprintf(
                '%s (version %s)',
                $this->name,
                $this->version
            ))
            ->newLine()
            ->line('Usage:')
            ->newLine()
            ->text(
                $this->program,
                $formatter
                    ->setForeground(new Yellow())
                    ->setFixedWidth(strlen($this->program) + 1)
                    ->setTextIndent(2)
            )
            ->line('<command> [<arguments>] [<options>]')
            ->newLine()
            ->line('Commands:')
            ->newLine();

        foreach ($commands as $command) {
            if ($command instanceof CommandInterface) {
                $output
                    ->text(
                        $command->getName(),
                        $formatter
                            ->setForeground(new Yellow())
                            ->setFixedWidth(22)
                            ->setTextIndent(2)
                    )
                    ->line($command->getDescription());
            }
        }

        $output
            ->newLine()
            ->line('Options:')
            ->newLine();

        foreach ($definition->getOptions() as $option) {
            if ($option instanceof OptionInterface) {
                $notation = $this->getOptionNotation($option);
                $output
                    ->text(
                        $notation,
                        $formatter
                            ->setForeground(new Yellow())
                            ->setFixedWidth(22)
                            ->setTextIndent(2)
                    )
                    ->line($option->getDescription());
            }
        }

        $output
            ->newLine()
            ->line(sprintf(
                'See \'%s <command> --help\' for more information about a command.',
                $this->program
            ));

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function command(CommandInterface $command, bool $short = null): DescriptorInterface
    {
        $short = $short ?? false;
        $output = $this->output;
        $formatter = $output->getFormatter();
        $definition = $command->getDefinition();

        if ($short === true) {
            $output
                ->newLine()
                ->line(sprintf(
                    'See \'%s %s --help\' for more information about the command.',
                    $this->program,
                    $command->getName()
                ));

            return $this;
        }

        $output
            ->line(sprintf(
                '%s (version %s)',
                $this->name,
                $this->version
            ))
            ->newLine()
            ->line('Usage:')
            ->newLine()
            ->text(
                $this->program,
                $formatter
                    ->setForeground(new Yellow())
                    ->setFixedWidth(strlen($this->program) + 1)
                    ->setTextIndent(2)
            )
            ->text(sprintf(
                '%s ',
                $command->getName()
            ));

        $operands = $definition->getOperands();
        if (empty($operands) === false) {
            foreach ($operands as $operand) {
                $output->text(sprintf(
                    '<%s> ',
                    $operand->getName()
                ));
            }
        }

        $options = $definition->getOptions();
        if (empty($options) === false) {
            $output
                ->line('[<options>] ')
                ->newLine()
                ->line('Options:')
                ->newLine();

            foreach ($options as $option) {
                $notation = $this->getOptionNotation($option);
                $output
                    ->text(
                        $notation,
                        $formatter
                            ->setForeground(new Yellow())
                            ->setFixedWidth(22)
                            ->setTextIndent(2)
                    )
                    ->line($option->getDescription());
            }
        } else {
            $output->newLine();
        }

        $output
            ->newLine()
            ->line(sprintf(
                'See \'%s --help\' for more information about this shell and default options.',
                $this->program
            ));

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function suggest(CommandInterface $command = null): DescriptorInterface
    {
        $output = $this->output;
        $formatter = $output->getFormatter();

        if ($command instanceof CommandInterface) {
            $output
                ->newLine()
                ->text('Did you mean "')
                ->text(
                    $command->getName(),
                    $formatter->setForeground(new Yellow())
                )
                ->line('"?');
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function exception(Throwable $exception): DescriptorInterface
    {
        $output = $this->output;
        $formatter = $output->getFormatter();

        $output
            ->line(
                $exception->getMessage(),
                $formatter->setForeground(new Red())
            );

        return $this;
    }

    /**
     * Get option notation.
     *
     * @param OptionInterface $option
     * @return string
     */
    protected function getOptionNotation(OptionInterface $option): string
    {
        $multiple = $option->isMultiple();
        $short = $option->getShort();
        $long = $option->getLong();
        $flag = $option->isFlag();

        $notation = '';
        if ($short !== null) {
            $notation .= '-' . $short;

            if ($flag === false) {
                $notation .= '=';
            } elseif ($multiple === true) {
                $notation .= '+';
            }
        }

        if ($long !== null) {
            if (strlen($notation) > 0) {
                $notation .= '|';
            }

            $notation .= '--' . $long;

            if ($flag === false) {
                $notation .= '=';
            } elseif ($multiple === true) {
                $notation .= '+';
            }
        }

        return $notation;
    }
}
