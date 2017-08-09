<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Output;

use ExtendsFramework\Console\Output\Adapter\AdapterInterface;
use PHPUnit\Framework\TestCase;

class OutputTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Output\Output::__construct()
     * @covers \ExtendsFramework\Console\Output\Output::text()
     */
    public function testCanOutputText(): void
    {
        $adapter = $this->createMock(AdapterInterface::class);
        $adapter
            ->expects($this->once())
            ->method('write')
            ->with('Hello world!');

        /**
         * @var AdapterInterface $adapter
         */
        $output = new Output($adapter);
        $output->text('Hello world!');
    }

    /**
     * @covers \ExtendsFramework\Console\Output\Output::__construct()
     * @covers \ExtendsFramework\Console\Output\Output::text()
     */
    public function testCanOutputTextWithNewline(): void
    {
        $adapter = $this->createMock(AdapterInterface::class);
        $adapter
            ->expects($this->once())
            ->method('write')
            ->with('Hello world!' . PHP_EOL);

        /**
         * @var AdapterInterface $adapter
         */
        $output = new Output($adapter);
        $output->text('Hello world!', true);
    }

    /**
     * @covers \ExtendsFramework\Console\Output\Output::__construct()
     * @covers \ExtendsFramework\Console\Output\Output::line()
     * @covers \ExtendsFramework\Console\Output\Output::text()
     */
    public function testCanOutputLine(): void
    {
        $adapter = $this->createMock(AdapterInterface::class);
        $adapter
            ->expects($this->once())
            ->method('write')
            ->with('Hello world!' . PHP_EOL);

        /**
         * @var AdapterInterface $adapter
         */
        $output = new Output($adapter);
        $output->line('Hello world!');
    }

    /**
     * @covers \ExtendsFramework\Console\Output\Output::__construct()
     * @covers \ExtendsFramework\Console\Output\Output::paragraph()
     * @covers \ExtendsFramework\Console\Output\Output::text()
     */
    public function testCanOutputParagraph(): void
    {
        $adapter = $this->createMock(AdapterInterface::class);
        $adapter
            ->expects($this->once())
            ->method('write')
            ->with(
                'Lorem Ipsum is simply dummy' .
                PHP_EOL .
                'text of the printing and' .
                PHP_EOL .
                'typesetting industry.' .
                PHP_EOL
            );

        /**
         * @var AdapterInterface $adapter
         */
        $output = new Output($adapter);
        $output->paragraph('Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 30);
    }
}
