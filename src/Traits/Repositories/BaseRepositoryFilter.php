<?php

namespace Iqbalatma\LaravelServiceRepo\Traits\Repositories;

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
        $this->requestQueryParam = config("servicerepo.filter_query_param_root") ?
            request()->query(config("servicerepo.filter_query_param_root"), []) :
            request()->query();

        return $this;
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
