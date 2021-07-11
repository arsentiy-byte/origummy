<?php

declare(strict_types=1);

namespace App\Models\Category;

use App\Models\BaseModel;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Category.
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $slug
 * @property bool $status
 * @property bool $is_default
 * @property int|null $parent_id
 * @property-read Collection|CategoryImage[] $images
 * @property-read Collection|Product[] $products
 * @property-read Category $parent
 * @property-read Collection|Category[] $children
 */
final class Category extends BaseModel
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'title', 'description', 'slug', 'status', 'is_default', 'parent_id',
    ];

    /**
     * @return HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(CategoryImage::class, 'category_id');
    }

    /**
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    /**
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }
}
