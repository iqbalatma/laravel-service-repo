<?php

namespace Iqbalatma\LaravelServiceRepo\Exceptions;

use Exception;
use Throwable;

class DeleteDataThatStillUsedException extends Exception
{
    public function __construct(string $message = "You cannot delete this data because still used by another entity", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
