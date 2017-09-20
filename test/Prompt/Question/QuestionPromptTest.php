<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Prompt\Question;

use ExtendsFramework\Console\Input\InputInterface;
use ExtendsFramework\Console\Output\OutputInterface;
use ExtendsFramework\Console\Output\Posix\Exception\StreamWriteFailed;
use PHPUnit\Framework\TestCase;

class QuestionPromptTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Prompt\AbstractPrompt::__construct()
     * @covers \ExtendsFramework\Console\Prompt\Question\QuestionPrompt::__construct()
     * @covers \ExtendsFramework\Console\Prompt\Question\QuestionPrompt::prompt()
     */
    public function testCanPromptQuestion(): void
    {
        $input = $this->createMock(InputInterface::class);
        $input
            ->expects($this->once())
            ->method('line')
            ->willReturn('Very good!');

        $output = $this->createMock(OutputInterface::class);
        $output
            ->expects($this->once())
            ->method('text')
            ->with('How are you doing?: ')
            ->willReturnSelf();

        /**
         * @var InputInterface  $input
         * @var OutputInterface $output
         */
        $question = new QuestionPrompt($input, $output, 'How are you doing?');
        $answer = $question->prompt();

        static::assertSame('Very good!', $answer);
    }

    /**
     * @covers \ExtendsFramework\Console\Prompt\AbstractPrompt::__construct()
     * @covers \ExtendsFramework\Console\Prompt\Question\QuestionPrompt::__construct()
     * @covers \ExtendsFramework\Console\Prompt\Question\QuestionPrompt::prompt()
     */
    public function testWillPromptQuestionUntilValidAnswer(): void
    {
        $input = $this->createMock(InputInterface::class);
        $input
            ->expects($this->exactly(2))
            ->method('line')
            ->willReturnOnConsecutiveCalls(null, 'Very good!');

        $output = $this->createMock(OutputInterface::class);
        $output
            ->expects($this->exactly(2))
            ->method('text')
            ->withConsecutive(['How are you doing?: '], ['How are you doing?: '])
            ->willReturnSelf();

        /**
         * @var InputInterface  $input
         * @var OutputInterface $output
         */
        $question = new QuestionPrompt($input, $output, 'How are you doing?');
        $answer = $question->prompt();

        static::assertSame('Very good!', $answer);
    }

    /**
     * @covers \ExtendsFramework\Console\Prompt\AbstractPrompt::__construct()
     * @covers \ExtendsFramework\Console\Prompt\Question\QuestionPrompt::__construct()
     * @covers \ExtendsFramework\Console\Prompt\Question\QuestionPrompt::prompt()
     */
    public function testCanReturnEmptyAnswerWhenNotRequired(): void
    {
        $input = $this->createMock(InputInterface::class);
        $input
            ->expects($this->once())
            ->method('line')
            ->willReturn(null);

        $output = $this->createMock(OutputInterface::class);
        $output
            ->expects($this->once())
            ->method('text')
            ->with('How are you doing?: ')
            ->willReturnSelf();

        /**
         * @var InputInterface  $input
         * @var OutputInterface $output
         */
        $question = new QuestionPrompt($input, $output, 'How are you doing?', false);
        $answer = $question->prompt();

        static::assertNull($answer);
    }

    /**
     * @covers                   \ExtendsFramework\Console\Prompt\AbstractPrompt::__construct()
     * @covers                   \ExtendsFramework\Console\Prompt\Question\QuestionPrompt::__construct()
     * @covers                   \ExtendsFramework\Console\Prompt\Question\QuestionPrompt::prompt()
     * @expectedException        \ExtendsFramework\Console\Prompt\Question\Exception\QuestionPromptFailed
     * @expectedExceptionCode    0
     * @expectedExceptionMessage Failed to prompt question.
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
            ->with('How are you doing?: ')
            ->willThrowException($exception);

        /**
         * @var InputInterface  $input
         * @var OutputInterface $output
         */
        $question = new QuestionPrompt($input, $output, 'How are you doing?');
        $question->prompt();
    }
}
