<?php

namespace Iqbalatma\LaravelServiceRepo\Traits;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\AbstractPaginator;
use Iqbalatma\LaravelUtils\APIResponse;

/**
 * @property array formattedResponse
 */
trait FormatResponsePayloadTrait
{
    /**
     * @return FormatResponsePayloadTrait|\Iqbalatma\LaravelServiceRepo\APIResponse
     */
    protected function setResponseForPaginator(): self
    {
        if (count($this->formattedResponse) === 0 && $this->getData() instanceof Paginator) {
            $meta = $this->getData()->toArray();
            unset($meta["data"]);
            if (self::getMetaWrapper()){
                $meta = [self::getMetaWrapper() => $meta];
            }

            if (self::getPayloadWrapper()) {
                $this->formattedResponse[self::getPayloadWrapper()] = array_merge(
                    [JsonResource::$wrap ?? "data" => $this->getData()->toArray()["data"]],
                    $meta,
                );
            } else {
                $this->formattedResponse = array_merge(
                    $this->formattedResponse,
                    [JsonResource::$wrap ?? "data" => $this->getData()->toArray()["data"]],
                    $meta,
                );
            }
        }
        return $this;
    }

    /**
     * @return APIResponse|FormatResponsePayloadTrait
     */
    protected function setResponseForArrayable(): self
    {
        if (count($this->formattedResponse) === 0 && $this->getData() instanceof Arrayable) {
            $source = [JsonResource::$wrap ?? "data" => $this->getData()->toArray()];
            if (self::getPayloadWrapper()) {
                $this->formattedResponse[self::getPayloadWrapper()] = $source;
            } else {
                $this->formattedResponse = $source;
            }
        }
        return $this;
    }

    /**
     * @return APIResponse|FormatResponsePayloadTrait
     */
    protected function setResponseForAbstractPaginator(): self
    {
        if (count($this->formattedResponse) === 0 && ($this->getData()?->resource ?? null) instanceof AbstractPaginator) {
            $meta = $this->getData()->resource->toArray();
            unset($meta["data"]);
            if (self::getMetaWrapper()){
                $meta = [self::getMetaWrapper() => $meta];
            }

            if (self::getPayloadWrapper()) {
                $this->formattedResponse[self::getPayloadWrapper()] = array_merge(
                    [JsonResource::$wrap ?? 'data' => $this->getData()],
                    $meta,
                );
            } else {
                $this->formattedResponse = array_merge(
                    $this->formattedResponse,
                    [JsonResource::$wrap ?? 'data' => $this->getData()],
                    $meta
                );
            }
        }

        return $this;
    }

    /**
     * @return APIResponse|FormatResponsePayloadTrait
     */
    protected function setResponseForResource(): self
    {
        if (count($this->formattedResponse) === 0) {
            if (self::getPayloadWrapper()) {
                if (JsonResource::$wrap) {
                    $this->formattedResponse[self::getPayloadWrapper()] = $this->getData() ? [JsonResource::$wrap => $this->getData()] : null;
                } else {
                    $this->formattedResponse[self::getPayloadWrapper()] = $this->getData();
                }
            } elseif (!self::getPayloadWrapper() && $this->getData()) {
                if (JsonResource::$wrap) {
                    $this->formattedResponse[JsonResource::$wrap] = $this->getData();
                } else {
                    $this->formattedResponse = $this->getData();
                }
            }
        }

        return $this;
    }
}
