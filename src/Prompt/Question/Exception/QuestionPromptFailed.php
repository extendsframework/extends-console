<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Prompt\Question\Exception;

use Exception;
use ExtendsFramework\Console\Prompt\PromptException;

class QuestionPromptFailed extends Exception implements PromptException
{
}
