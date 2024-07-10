<?php

namespace Iqbalatma\LaravelServiceRepo\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string created_by_id
 * @property User created_by
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
        return $this->belongsTo(User::class, $this->getCreatorColumnName(), "id");
    }
}
