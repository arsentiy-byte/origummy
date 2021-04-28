<?php

declare(strict_types=1);

namespace App\Traits\Materials;

use Illuminate\Support\Facades\DB;

trait MaterialAdditionalAttributes
{
    /**
     * @return string|null
     */
    public function getTypeKeyAttribute(): ?string
    {
        return $this->type;
    }

    /**
     * @return int|null
     */
    public function getStatusAttribute(): ?int
    {
        $query = $this->reserveList()->first();

        return $query ? $query->status : null;
    }

    /**
     * @return int
     */
    public function getAvailabilityAttribute(): ?int
    {
        return $this->items()->count('inv_id');
    }

    /**
     * @return string
     */
    public function getAuthorsAttribute(): ?string
    {
        $query = $this->authors()->select(DB::raw("(name||' '||surname) as name"))->get()->pluck('name')->toArray();

        return implode(',', $query);
    }

    /**
     * @return string|null
     */
    public function getIssnAttribute(): ?string
    {
        return null;
    }
}
