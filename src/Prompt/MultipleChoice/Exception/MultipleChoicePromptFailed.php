<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Prompt\MultipleChoice\Exception;

use Exception;
use ExtendsFramework\Console\Prompt\PromptException;

class MultipleChoicePromptFailed extends Exception implements PromptException
{
}
