<?php

namespace Iqbalatma\LaravelServiceRepo\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class DumpAPIException extends Exception
{
    public function __construct(public array $data) {
        parent::__construct('Dump API');
    }

    /**
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        return response()->json($this->data);
    }
}
