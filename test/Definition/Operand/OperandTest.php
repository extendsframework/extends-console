<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Definition\Operand;

use PHPUnit\Framework\TestCase;

class OperandTest extends TestCase
{
    /**
     * @covers \ExtendsFramework\Console\Definition\Operand\Operand::__construct()
     * @covers \ExtendsFramework\Console\Definition\Operand\Operand::getName()
     */
    public function testCanConstructAndGetParameter(): void
    {
        $operand = new Operand('fooBar');

        $this->assertSame('fooBar', $operand->getName());
    }
}
