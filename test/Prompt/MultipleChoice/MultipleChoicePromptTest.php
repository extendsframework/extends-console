<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Prompt\MultipleChoice;

use ExtendsFramework\Console\Input\InputInterface;
use ExtendsFramework\Console\Output\OutputInterface;
use PHPUnit\Framework\TestCase;

class MultipleChoicePromptTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::__construct()
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::setRequired()
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::prompt()
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::isValidOption()
     */
    public function testCanPromptMultipleChoice(): void
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
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::__construct()
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::setRequired()
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::prompt()
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::isValidOption()
     */
    public function testWillPromptMultipleChoiceUntilValidAnswer(): void
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
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::__construct()
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::setRequired()
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::prompt()
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::isValidOption()
     */
    public function testCanReturnEmptyAnswerWhenNotRequired(): void
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
