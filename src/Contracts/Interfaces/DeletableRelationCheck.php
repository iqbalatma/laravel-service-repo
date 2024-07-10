<?php

namespace Iqbalatma\LaravelServiceRepo\Contracts\Interfaces;

interface DeletableRelationCheck {
    /**
     * @return array
     */
    public function getRelationCheckBeforeDelete(): array;
}
