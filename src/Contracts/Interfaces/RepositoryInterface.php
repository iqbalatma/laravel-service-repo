<?php

namespace Iqbalatma\LaravelServiceRepo\Contracts\Interfaces;

use Illuminate\Database\Eloquent\Builder;
use Iqbalatma\LaravelServiceRepo\BaseRepository;

interface RepositoryInterface
{
    /**
     * @return Builder
     */
    public function getBaseQuery(): Builder;

    /**
     * @return Builder
     */
    public function build(): Builder;

    /**
     * @return BaseRepository
     */
    public static function init(): BaseRepository;

    /**
     * @return void
     */
    public function applyAdditionalFilterParams(): void;
}
