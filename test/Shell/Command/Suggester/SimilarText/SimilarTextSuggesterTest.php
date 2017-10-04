<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Shell\Command\Suggester\SimilarText;

use ExtendsFramework\Console\Shell\Command\CommandInterface;
use PHPUnit\Framework\TestCase;

class SimilarTextSuggesterTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Shell\Command\Suggester\SimilarText\SimilarTextSuggester::__construct()
     * @covers \ExtendsFramework\Console\Shell\Command\Suggester\SimilarText\SimilarTextSuggester::suggest()
     */
    public function testCanSuggestBestMatch(): void
    {
        $command1 = $this->createMock(CommandInterface::class);
        $command1
            ->expects($this->once())
            ->method('getName')
            ->willReturn('some.task');

        $command2 = $this->createMock(CommandInterface::class);
        $command2
            ->expects($this->once())
            ->method('getName')
            ->willReturn('do.task');

        $suggester = new SimilarTextSuggester();
        $suggestion = $suggester->suggest('d_task', ...[
            $command1,
            $command2,
        ]);

        $this->assertSame($command2, $suggestion);
    }

    /**
     * @covers \ExtendsFramework\Console\Shell\Command\Suggester\SimilarText\SimilarTextSuggester::__construct()
     * @covers \ExtendsFramework\Console\Shell\Command\Suggester\SimilarText\SimilarTextSuggester::suggest()
     */
    public function testCanSuggestExactMatch(): void
    {
        $command1 = $this->createMock(CommandInterface::class);
        $command1
            ->expects($this->once())
            ->method('getName')
            ->willReturn('some.task');

        $command2 = $this->createMock(CommandInterface::class);
        $command2
            ->expects($this->never())
            ->method('getName');

        $suggester = new SimilarTextSuggester();
        $suggestion = $suggester->suggest('some.task', ...[
            $command1,
            $command2,
        ]);

        $this->assertSame($command1, $suggestion);
    }

    /**
     * @covers \ExtendsFramework\Console\Shell\Command\Suggester\SimilarText\SimilarTextSuggester::__construct()
     * @covers \ExtendsFramework\Console\Shell\Command\Suggester\SimilarText\SimilarTextSuggester::suggest()
     */
    public function testCanNotSuggestBestMatch(): void
    {
        $command1 = $this->createMock(CommandInterface::class);
        $command1
            ->expects($this->once())
            ->method('getName')
            ->willReturn('some.task');

        $command2 = $this->createMock(CommandInterface::class);
        $command2
            ->expects($this->once())
            ->method('getName')
            ->willReturn('do.task');

        $suggester = new SimilarTextSuggester();
        $suggestion = $suggester->suggest('foo.bar', ...[
            $command1,
            $command2,
        ]);

        $this->assertNull($suggestion);
    }
}
