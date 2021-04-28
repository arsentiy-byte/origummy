<?php

declare(strict_types=1);

namespace App\Traits\Materials;

use App\Models\Acquisition\Item;
use App\Models\Acquisition\Publisher;
use App\Models\Materials\Author;
use App\Models\Materials\ReserveList;
use App\Models\Materials\Type;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait MaterialRelationships
{
    /**
     * @return BelongsTo|null
     */
    public function publisher(): ?BelongsTo
    {
        return $this->belongsTo(Publisher::class, 'publisher_id');
    }

    /**
     * @return HasMany|HasManyThrough|null
     */
    public function authors(): HasMany | HasManyThrough | null
    {
        return $this->hasMany(Author::class, $this->primaryKey);
    }

    /**
     * @return HasOne|null
     */
    public function type(): ?HasOne
    {
        return $this->hasOne(Type::class, 'key', 'type');
    }

    /**
     * @return HasMany|HasManyThrough|null
     */
    public function reserveList(): HasMany | HasManyThrough | null
    {
        return $this->hasMany(ReserveList::class, $this->primaryKey);
    }

    /**
     * @return HasMany|HasManyThrough|null
     */
    public function items(): HasMany | HasManyThrough | null
    {
        return $this->hasMany(Item::class, $this->primaryKey);
    }
}
