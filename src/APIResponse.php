<?php

namespace Iqbalatma\LaravelServiceRepo;

use Error;
use Exception;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\CursorPaginator;
use Iqbalatma\LaravelServiceRepo\Contracts\Abstracts\BaseAPIResponse;
use Iqbalatma\LaravelServiceRepo\Contracts\Interfaces\ResponseCodeInterface;
use Iqbalatma\LaravelServiceRepo\Traits\FormatResponsePayloadTrait;
use Throwable;

class APIResponse extends BaseAPIResponse
{
    use FormatResponsePayloadTrait;

    /**
     * @param JsonResource|ResourceCollection|Arrayable|LengthAwarePaginator|CursorPaginator|array|null $data
     * @param string $message
     * @param ResponseCodeInterface|null $responseCode
     * @param string|array|null $errors
     * @param Error|Exception|Throwable|null $exception
     */
    public function __construct(
        JsonResource|ResourceCollection|Arrayable|LengthAwarePaginator|CursorPaginator|array|null $data = null,
        string                                                                                    $message = "",
        ResponseCodeInterface|null                                                                $responseCode = null,
        string|array|null                                                                         $errors = null,
        Error|Exception|Throwable|null                                                            $exception = null
    )
    {
        $this->data = $data;
        $this->message = $message;
        $this->responseCode = $responseCode;
        $this->errors = $errors;
        $this->exception = $exception;
        $this->formattedResponse = [];

        $this->setBaseFormat()
            ->setFormattedResponse();
    }


    /**
     * @return APIResponse
     */
    protected function setBaseFormat(): self
    {
        $this->baseFormat = [
            config("utils.api_response.response_code") => $this->getCode()->name,
            "message" => $this->getMessage(),
            "timestamp" => now()
        ];

        #when errors are detected, mostly for validation error
        if ($this->errors) {
            $this->baseFormat["errors"] = $this->errors;
        }

        #when payload wrapper is set, we will preserve the key
        if (self::getPayloadWrapper()) {
            $this->baseFormat[self::getPayloadWrapper()] = null;
        }

        if ($this->exception instanceof Throwable && config("utils.is_show_debug")) {
            $this->baseFormat["user_request"] = [
                'ip_address' => request()->getClientIp() ?? null,
                'base_url' => request()->getBaseUrl() ?? null,
                'path' => request()->getUri() ?? null,
                'params' => request()->getQueryString() ?? null,
                'origin' => request()->ip() ?? null,
                'method' => request()->getMethod() ?? null,
                'header' => request()->headers->all() ?? null,
                'body' => request()->all() ?? null,
            ];
            $this->baseFormat["exception"] = [
                "name" => get_class($this->exception),
                "message" => $this->exception->getMessage(),
                "http_code" => $this->getHttpCode(),
                "code" => $this->exception->getCode(),
                "file" => $this->exception->getFile(),
                "line" => $this->exception->getLine(),
                "trace" => $this->exception->getTraceAsString(),
            ];
        }

        return $this;
    }

    /**
     * @return void
     */
    protected function setFormattedResponse(): void
    {
        $this->setResponseForPaginator()
            ->setResponseForArrayable()
            ->setResponseForAbstractPaginator()
            ->setResponseForResource();
    }
}
