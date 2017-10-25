<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Task;

interface TaskInterface
{
    /**
     * Execute task.
     *
     * Return exit status should be in the range 0 to 254. Status 255 is preserved for PHP and should not be used.
     * Status 0 should be used when task is executed succesfully.
     *
     * @param array $data
     * @return int
     * @throws TaskException
     */
    public function execute(array $data): int;
}
