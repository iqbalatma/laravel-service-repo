<?php

namespace Iqbalatma\LaravelServiceRepo\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmptyDataException extends Exception
{
    public  $message;
    public  $status;
    public function __construct(string $message = "The data you requested not found", int $status = JsonResponse::HTTP_NOT_FOUND)
    {
        $this->message = $message;
        $this->status = $status;
    }
    public function render(Request $request)
    {
        return false;
    }
}
