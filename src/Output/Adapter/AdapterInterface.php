<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Output\Adapter;

interface AdapterInterface
{
    /**
     * Write $text to adapter.
     *
     * @param string $text
     * @return AdapterInterface
     * @throws AdapterException
     */
    public function write(string $text): AdapterInterface;
}
