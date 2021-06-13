<?php

declare(strict_types=1);

namespace App\Models;

use App\Filters\BaseFilter;
use App\Traits\TableNameGetterTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    use HasFactory, TableNameGetterTrait;

    /**
     * @param Builder $builder
     * @param BaseFilter $filters
     * @return Builder
     */
    public function scopeFilter(Builder $builder, BaseFilter $filters): Builder
    {
        return $filters->apply($builder);
    }

    /**
     * @param $date
     * @return string
     */
    public function getCreatedAtAttribute($date): string
    {
        return Carbon::createFromTimeString($date)->format('Y-m-d H:i:s');
    }

    /**
     * @param $date
     * @return string
     */
    public function getUpdatedAtAttribute($date): string
    {
        return Carbon::createFromTimeString($date)->format('Y-m-d H:i:s');
    }
}
