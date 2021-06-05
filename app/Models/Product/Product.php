<?php

declare(strict_types=1);

namespace App\Models\Product;

use App\Models\BaseModel;
use App\Models\Category\Category;
use App\Models\Promotion\ProductPromotion;
use App\Models\Promotion\Promotion;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * Class Product.
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property int $price
 * @property int|null $old_price
 * @property int|null $count
 * @property int $category_id
 * @property bool $status
 * @property-read Category $category
 * @property-read Promotion[] $promotions
 * @property-read ProductImage[] $images
 * @property-read Product $relatedProducts
 */
final class Product extends BaseModel
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'title', 'description', 'price', 'old_price', 'count', 'category_id', 'status',
    ];

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * @return HasManyThrough
     */
    public function promotions(): HasManyThrough
    {
        return $this->hasManyThrough(Promotion::class, ProductPromotion::class, 'product_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    /**
     * @return HasManyThrough
     */
    public function relatedProducts(): HasManyThrough
    {
        return $this->hasManyThrough(self::class, ProductRelation::class, 'main_product_id', 'id');
    }
}