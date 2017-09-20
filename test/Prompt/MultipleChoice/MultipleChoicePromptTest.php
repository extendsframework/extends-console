<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Prompt\MultipleChoice;

use ExtendsFramework\Console\Input\InputInterface;
use ExtendsFramework\Console\Output\OutputInterface;
use ExtendsFramework\Console\Output\Posix\Exception\StreamWriteFailed;
use PHPUnit\Framework\TestCase;

class MultipleChoicePromptTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Prompt\AbstractPrompt::__construct()
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::__construct()
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
            ->expects($this->once())
            ->method('text')
            ->with('Continue? [y,n]: ')
            ->willReturnSelf();

        /**
         * @var InputInterface  $input
         * @var OutputInterface $output
         */
        $multipleChoice = new MultipleChoicePrompt($input, $output, 'Continue?', ['y', 'n']);
        $continue = $multipleChoice->prompt();

        static::assertSame('y', $continue);
    }

    /**
     * @covers \ExtendsFramework\Console\Prompt\AbstractPrompt::__construct()
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::__construct()
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::prompt()
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::isValidOption()
     */
    public function testWillPromptMultipleChoiceUntilValidAnswer(): void
    {
        $input = $this->createMock(InputInterface::class);
        $input
            ->expects($this->exactly(2))
            ->method('character')
            ->willReturnOnConsecutiveCalls('a', 'y');

        $output = $this->createMock(OutputInterface::class);
        $output
            ->expects($this->exactly(2))
            ->method('text')
            ->withConsecutive(['Continue? [y,n]: '], ['Continue? [y,n]: '])
            ->willReturnSelf();

        /**
         * @var InputInterface  $input
         * @var OutputInterface $output
         */
        $multipleChoice = new MultipleChoicePrompt($input, $output, 'Continue?', ['y', 'n']);
        $continue = $multipleChoice->prompt();

        static::assertSame('y', $continue);
    }

    /**
     * @covers \ExtendsFramework\Console\Prompt\AbstractPrompt::__construct()
     * @covers \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::__construct()
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
            ->expects($this->once())
            ->method('text')
            ->with('Continue? [y,n]: ')
            ->willReturnSelf();

        /**
         * @var InputInterface  $input
         * @var OutputInterface $output
         */
        $multipleChoice = new MultipleChoicePrompt($input, $output, 'Continue?', ['y', 'n'], false);
        $continue = $multipleChoice->prompt();

        static::assertNull($continue);
    }

    /**
     * @covers                   \ExtendsFramework\Console\Prompt\AbstractPrompt::__construct()
     * @covers                   \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::__construct()
     * @covers                   \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::prompt()
     * @covers                   \ExtendsFramework\Console\Prompt\MultipleChoice\MultipleChoicePrompt::isValidOption()
     * @expectedException        \ExtendsFramework\Console\Prompt\MultipleChoice\Exception\MultipleChoicePromptFailed
     * @expectedExceptionCode    0
     * @expectedExceptionMessage Failed to prompt multiple choice question.
     */
    public function testCanCatchInputAndOutputException(): void
    {
        $input = $this->createMock(InputInterface::class);

        /** @var StreamWriteFailed $exception */
        $exception = $this->createMock(StreamWriteFailed::class);
        $output = $this->createMock(OutputInterface::class);
        $output
            ->expects($this->once())
            ->method('text')
            ->with('Continue? [y,n]: ')
            ->willThrowException($exception);

        /**
         * @var InputInterface  $input
         * @var OutputInterface $output
         */
        $multipleChoice = new MultipleChoicePrompt($input, $output, 'Continue?', ['y', 'n']);
        $multipleChoice->prompt();
    }
}
