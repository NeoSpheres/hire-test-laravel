<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

final class StateConflictException extends Exception
{
    /**
     * @var int
     */
    protected $code = 409;
}
