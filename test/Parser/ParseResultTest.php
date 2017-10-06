<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Parser;

use PHPUnit\Framework\TestCase;

class ParseResultTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Parser\ParseResult::__construct()
     * @covers \ExtendsFramework\Console\Parser\ParseResult::getParsed()
     * @covers \ExtendsFramework\Console\Parser\ParseResult::getRemaining()
     * @covers \ExtendsFramework\Console\Parser\ParseResult::isStrict()
     */
    public function testCanGetParameters(): void
    {
        $parsed = ['foo' => 'bar'];

        $remaining = ['qux' => 'quux'];

        $result = new ParseResult($parsed, $remaining, true);

        $this->assertSame($parsed, $result->getParsed());
        $this->assertSame($remaining, $result->getRemaining());
        $this->assertTrue($result->isStrict());
    }
}
