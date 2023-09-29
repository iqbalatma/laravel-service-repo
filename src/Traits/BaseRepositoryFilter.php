<?php

namespace Iqbalatma\LaravelServiceRepo\Traits;

use Iqbalatma\LaravelServiceRepo\BaseRepository;

trait BaseRepositoryFilter
{
    private static string $defaultOperator = "=";
    private array $requestQueryParam;


    /**
     * @return RepositoryFilter|BaseRepository
     */
    private function setRequestQueryParam(): self
    {
        $this->requestQueryParam = request()->query();

        return $this;
    }

    /**
     * @return bool
     */
    private function isFilterRequestExists(): bool
    {
        return isset($this->requestQueryParam["filter"]) && is_array($this->requestQueryParam["filter"]);
    }


    /**
     * @param string $operator
     * @param ?string $value
     * @return void
     */
    private function checkLikeOperator(string $operator, ?string &$value): void
    {
        if (!is_null($value) && strtolower($operator) === "like") {
            $value = "%$value%";
        }
    }

}