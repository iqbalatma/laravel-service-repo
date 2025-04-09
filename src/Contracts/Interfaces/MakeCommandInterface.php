<?php

namespace Iqbalatma\LaravelServiceRepo\Contracts\Interfaces;

interface MakeCommandInterface
{
    /**
     * @return array
     */
    public function getStubVariables(): array;

    /**
     * @return string
     */
    public function getStubContent(): string;
}
