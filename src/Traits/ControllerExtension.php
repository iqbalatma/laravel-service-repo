<?php

namespace Iqbalatma\LaravelServiceRepo\Traits;

trait ControllerExtension
{
    protected array $responseMessages;

    /**
     * Use to get response message
     *
     * @param string $context
     * @return string
     */
    public function getResponseMessage(string $context): string
    {
        return $this->responseMessages[$context];
    }
}
