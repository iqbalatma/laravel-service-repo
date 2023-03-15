<?php

namespace Iqbalatma\LaravelExtend\Traits;

use Iqbalatma\LaravelExtend\BaseRepository;

trait RepositoryExtend {
    /**
     * Use to add with relation on model
     *
     * @param array $relations
     * @return BaseRepository
     */
    public function with(array|string $relations): BaseRepository
    {
        $this->model = $this->model->with($relations);
        return $this;
    }
}
