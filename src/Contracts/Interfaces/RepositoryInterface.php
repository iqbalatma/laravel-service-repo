<?php

namespace Iqbalatma\LaravelServiceRepo\Contracts\Interfaces;

use Illuminate\Database\Eloquent\Builder;
use Iqbalatma\LaravelServiceRepo\BaseRepository;

interface RepositoryInterface
{
    public function getBaseQuery(): Builder;
    public function build(): Builder;
    public static function init(): BaseRepository;
    public function applyAdditionalFilterParams(): void;
}
