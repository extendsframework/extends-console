<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Definition\Option;

interface OptionFactoryInterface
{
    /**
     * @param array $config
     * @return OptionInterface
     */
    public function create(array $config): OptionInterface;
}
