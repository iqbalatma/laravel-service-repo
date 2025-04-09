<?php

namespace Iqbalatma\LaravelServiceRepo\Contracts\Abstracts;

use Error;
use Exception;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Iqbalatma\LaravelServiceRepo\Contracts\Interfaces\ResponseCodeInterface;
use Iqbalatma\LaravelServiceRepo\ResponseCode;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

abstract class BaseAPIResponse implements Responsable
{
    protected array $baseFormat;
    protected $formattedResponse;
    protected JsonResource|ResourceCollection|Arrayable|LengthAwarePaginator|CursorPaginator|array|null $data;
    protected string $message;
    protected ResponseCodeInterface|null $responseCode;
    protected string|array|null $errors;
    protected Error|Exception|Throwable|null $exception;


    /**
     * @return void
     */
    abstract protected function setFormattedResponse(): void;

    abstract protected function setBaseFormat(): self;


    /**
     * @param $request
     * @return Response
     */
    public function toResponse($request): Response
    {
        return response()->json(
            collect($this->getBaseFormat())->merge($this->getFormattedResponse()),
            $this->getHttpCode()
        );
    }


    /**
     * @return array
     */
    protected function getBaseFormat(): array
    {
        return $this->baseFormat;
    }


    /**
     * @return string
     */
    protected function getMessage(): string
    {
        return $this->message;
    }


    /**
     * @return JsonResource|ResourceCollection|Arrayable|LengthAwarePaginator|CursorPaginator|array|null
     */
    protected function getData(): JsonResource|ResourceCollection|Arrayable|LengthAwarePaginator|CursorPaginator|array|null
    {
        return $this->data;
    }


    /**
     * @return mixed
     */
    protected function getFormattedResponse(): mixed
    {
        return $this->formattedResponse;
    }


    /**
     * @return ResponseCodeInterface
     */
    protected function getCode(): ResponseCodeInterface
    {
        if (is_null($this->responseCode)) {
            if ($this->exception) {
                if ($this->exception instanceof HttpExceptionInterface) {
                    $httpCode = (string)$this->exception->getStatusCode();
                    if (str_starts_with($httpCode, "5")) {
                        return ResponseCode::ERR_INTERNAL_SERVER_ERROR();
                    }

                    if (str_starts_with($httpCode, "4")) {
                        return ResponseCode::ERR_BAD_REQUEST();
                    }

                    return ResponseCode::ERR_UNKNOWN();
                }

                return ResponseCode::ERR_UNKNOWN();
            }

            return ResponseCode::SUCCESS();
        }

        return $this->responseCode;
    }

    /**
     * @return int
     */
    protected function getHttpCode(): int
    {
        if ($this->exception instanceof HttpExceptionInterface) {
            return $this->exception->getStatusCode();
        }
        return $this->getCode()->httpCode ?? Response::HTTP_INTERNAL_SERVER_ERROR;
    }


    /**
     * @return string|null
     */
    protected static function getPayloadWrapper(): string|null
    {
        return config("utils.api_response.payload_wrapper");
    }

    /**
     * @return string|null
     */
    protected static function getMetaWrapper(): string|null
    {
        return config("utils.api_response.meta_wrapper");
    }
}
