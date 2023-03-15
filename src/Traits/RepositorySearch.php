<?php

namespace Iqbalatma\LaravelServiceRepo\Traits;

trait RepositorySearch
{
    /**
     * Use to searchable column
     *
     * @param array $searchableColumn
     * @return object
     */
    public function searchableColumn(array $searchableColumn = []):object
    {
        if ($searchTerm  = request()->input("search")) {
            foreach ($searchableColumn as $key => $value) {
                $this->model = $this->model->orWhere($value, "LIKE", "%$searchTerm%");
            }
        }

        return $this;
    }
}
