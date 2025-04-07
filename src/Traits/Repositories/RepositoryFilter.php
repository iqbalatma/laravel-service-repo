<?php

namespace Iqbalatma\LaravelServiceRepo\Traits\Repositories;

use Iqbalatma\LaravelServiceRepo\BaseRepositoryExtend;

trait RepositoryFilter
{
    use RepositoryFilterMainModel, RepositoryFilterRelationModel;

    /**
     * @param array|null $filterableColumns
     * @param array|null $relationFilterableColumns
     * @return RepositoryFilter|BaseRepositoryExtend
     */
    public function _filterColumn(?array $filterableColumns = null, ?array $relationFilterableColumns = null): self
    {
        $this->setRequestQueryParam()
            ->setFilterableColumns($filterableColumns)
            ->setRelationFilterableColumns($relationFilterableColumns);

        $this->defaultFilterableColumn()
            ->filterMainModel()
            ->filterRelationModel();

        return $this;
    }
}
