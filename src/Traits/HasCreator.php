<?php

namespace Iqbalatma\LaravelServiceRepo\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin Model
 * @property string created_by_id
 */
trait HasCreator
{
    /**
     * @return string
     */
    public function getCreatorColumnName(): string
    {
        $createdByColumn = 'created_by_id';
        if (property_exists(static::class, 'createdByColumn')) {
            $createdByColumn = $this->createdByColumn;
        }
        return $createdByColumn;
    }

    /**
     * @return BelongsTo
     */
    public function created_by(): BelongsTo
    {
        return $this->belongsTo(config("servicerepo.traits.has_creator_user_model"), $this->getCreatorColumnName(), "id");
    }
}
