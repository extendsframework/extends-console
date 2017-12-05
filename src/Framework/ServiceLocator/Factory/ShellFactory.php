<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Framework\ServiceLocator\Factory;

use ExtendsFramework\Shell\ShellBuilder;
use ExtendsFramework\Shell\ShellInterface;
use ExtendsFramework\ServiceLocator\Resolver\Factory\ServiceFactoryInterface;
use ExtendsFramework\ServiceLocator\ServiceLocatorInterface;

class ShellFactory implements ServiceFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function createService(string $key, ServiceLocatorInterface $serviceLocator, array $extra = null): ShellInterface
    {
        $config = $serviceLocator->getConfig();
        $config = $config[ShellInterface::class] ?? [];

        $builder = (new ShellBuilder())
            ->setName($config['name'] ?? null)
            ->setProgram($config['program'] ?? null)
            ->setVersion($config['version'] ?? null);

        foreach ($config['commands'] ?? [] as $command) {
            $builder->addCommand(
                $command['name'],
                $command['description'],
                $command['operands'] ?? [],
                $command['options'] ?? [],
                $command['parameters'] ?? []
            );
        }

        return $builder->build();
    }
}
