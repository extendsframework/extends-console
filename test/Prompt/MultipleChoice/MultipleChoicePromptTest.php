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
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::prompt()
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

        $this->assertSame('y', $continue);
    }

    /**
     * Required.
     *
     * Test that prompt will show again after not allowed answer (null) until valid answer ('y').
     *
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::__construct()
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::prompt()
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

        $this->assertSame('y', $continue);
    }

    /**
     * Not required.
     *
     * Test that prompt answer can be skipped (null) when not required.
     *
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::__construct()
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::prompt()
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
        $multipleChoice = new MultipleChoicePrompt('Continue?', ['y', 'n'], false);
        $continue = $multipleChoice->prompt($input, $output);

        $this->assertNull($continue);
    }
}
