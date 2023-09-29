<?php

namespace Iqbalatma\LaravelServiceRepo\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\ValidationException;
use Iqbalatma\LaravelServiceRepo\BaseRepository;
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

        if ($this->isFilterRequestExists()) {
            $this->defaultFilterableColumn()
                ->filterMainModel()
                ->filterRelationModel();
        }

        return $this;
    }
}
