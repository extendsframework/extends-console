<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Prompt\MultipleChoice;

use ExtendsFramework\Console\Input\InputInterface;
use ExtendsFramework\Console\Output\OutputInterface;
use PHPUnit\Framework\TestCase;

class MultipleChoicePromptTest extends TestCase
{
    /**
     * Prompt.
     *
     * Test that multiple choice prompt ('Continue?' with option 'y' and 'n') will be prompted ('Continue? [y,n]: ').
     *
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::__construct()
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::setRequired()
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::prompt()
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::isValidOption()
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::getQuestion()
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::getOptions()
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::isRequired()
     */
    public function testPrompt(): void
    {
        $input = $this->createMock(InputInterface::class);
        $input
            ->expects($this->once())
            ->method('character')
            ->willReturn('y');

        $output = $this->createMock(OutputInterface::class);
        $output
            ->expects($this->exactly(3))
            ->method('text')
            ->withConsecutive(
                ['Continue? '],
                ['[y,n]'],
                [': ']
            )
            ->willReturnSelf();

        /**
         * @var InputInterface  $input
         * @var OutputInterface $output
         */
        $multipleChoice = new MultipleChoicePrompt('Continue?', ['y', 'n']);
        $continue = $multipleChoice->prompt($input, $output);

        static::assertSame('y', $continue);
    }

    /**
     * Required.
     *
     * Test that prompt will show again after not allowed answer (null) until valid answer ('y').
     *
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::__construct()
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::setRequired()
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::prompt()
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::isValidOption()
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::getQuestion()
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::getOptions()
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::isRequired()
     */
    public function testRequired(): void
    {
        $input = $this->createMock(InputInterface::class);
        $input
            ->expects($this->exactly(2))
            ->method('character')
            ->willReturnOnConsecutiveCalls(null, 'y');

        $output = $this->createMock(OutputInterface::class);
        $output
            ->expects($this->exactly(6))
            ->method('text')
            ->withConsecutive(
                ['Continue? '],
                ['[y,n]'],
                [': '],
                ['Continue? '],
                ['[y,n]'],
                [': ']
            )
            ->willReturnSelf();

        /**
         * @var InputInterface  $input
         * @var OutputInterface $output
         */
        $multipleChoice = new MultipleChoicePrompt('Continue?', ['y', 'n']);
        $continue = $multipleChoice->prompt($input, $output);

        static::assertSame('y', $continue);
    }

    /**
     * Not required.
     *
     * Test that prompt answer can be skipped (null) when not required.
     *
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::__construct()
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::setRequired()
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::prompt()
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::isValidOption()
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::getQuestion()
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::getOptions()
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::isRequired()
     */
    public function testNotRequired(): void
    {
        $input = $this->createMock(InputInterface::class);
        $input
            ->expects($this->once())
            ->method('character')
            ->willReturn(null);

        $output = $this->createMock(OutputInterface::class);
        $output
            ->expects($this->exactly(3))
            ->method('text')
            ->withConsecutive(
                ['Continue? '],
                ['[y,n]'],
                [': ']
            )
            ->willReturnSelf();

        /**
         * @var InputInterface  $input
         * @var OutputInterface $output
         */
        $multipleChoice = new MultipleChoicePrompt('Continue?', ['y', 'n']);
        $continue = $multipleChoice
            ->setRequired(false)
            ->prompt($input, $output);

        static::assertNull($continue);
    }
}
