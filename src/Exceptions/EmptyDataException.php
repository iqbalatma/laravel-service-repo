<?php

namespace Iqbalatma\LaravelServiceRepo\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmptyDataException extends Exception
{
    /**
     * @var string $message
     */
    public  $message;

    /**
     * @var int $code
     */
    public $code;
    public function __construct(string $message = "The data you requested not found", int $code = JsonResponse::HTTP_NOT_FOUND)
    {
        parent::__construct();
        $this->message = $message;
        $this->code = $code;
    }


    public function render(Request $request):bool
    {
        return false;
    }
}
